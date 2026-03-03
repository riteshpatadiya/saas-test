<?php

namespace App\Services\Store;

use App\Models\Checkout;
use App\Models\CheckoutItem;
use App\Models\Inventory;
use App\Models\InventoryLevel;
use App\Models\ProductVariant;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use RuntimeException;

class CheckoutService
{
    public function create(object $store, array $data): CheckoutResult
    {
        $storeId    = $store->id;
        $locationId = (int) $data['store_location_id'];
        $items      = $data['items'];
        $key        = $data['idempotency_key'];

        /**
         * --------------------------------------------------
         * 1. Idempotency Protection
         * --------------------------------------------------
         */
        $existing = Checkout::query()
            ->where('store_id', $storeId)
            ->where('idempotency_key', $key)
            ->first();

        if ($existing) {
            return CheckoutResult::redirect($existing->id);
        }

        try {
            $checkout = DB::transaction(function () use (
                $storeId,
                $locationId,
                $items,
                $key
            ) {

                /**
                 * --------------------------------------------------
                 * 2. Load Variants (Store Scoped)
                 * --------------------------------------------------
                 */
                $variants = ProductVariant::query()
                    ->with('product')
                    ->where('store_id', $storeId)
                    ->whereIn('id', collect($items)->pluck('product_variant_id'))
                    ->get()
                    ->keyBy('id');

                if ($variants->count() !== count($items)) {
                    throw new RuntimeException('Invalid product variant.');
                }

                /**
                 * --------------------------------------------------
                 * 3. Atomic Stock Reservation
                 * --------------------------------------------------
                 */
                foreach ($items as $item) {
                    $variantId = (int) $item['product_variant_id'];
                    $qty       = (int) $item['quantity'];

                    $success = InventoryLevel::decrementAtomically(
                        variantId: $variantId,
                        locationId: $locationId,
                        qty: $qty
                    );

                    if (! $success) {
                        throw new RuntimeException(
                            "Insufficient stock for variant {$variantId}"
                        );
                    }
                }

                /**
                 * --------------------------------------------------
                 * 4. Create Checkout
                 * --------------------------------------------------
                 */
                $subtotal = $this->calculateSubtotal($items, $variants);
                $token    = $this->generateToken();

                $checkout = Checkout::create([
                    'store_id'          => $storeId,
                    'store_location_id' => $locationId,
                    'token'             => $token,
                    'idempotency_key'   => $key,
                    'status'            => Checkout::STATUS_OPEN,
                    'subtotal'          => $subtotal,
                    'tax'               => 0,
                    'total'             => $subtotal,
                    'expires_at'        => now()->addMinutes(10),
                ]);

                /**
                 * --------------------------------------------------
                 * 5. Create Items + Ledger Entries
                 * --------------------------------------------------
                 */
                foreach ($items as $item) {
                    $variant = $variants->get((int) $item['product_variant_id']);
                    $qty     = (int) $item['quantity'];

                    CheckoutItem::create([
                        'checkout_id'        => $checkout->id,
                        'product_id'         => $variant->product_id,
                        'product_variant_id' => $variant->id,
                        'sku'                => $variant->sku,
                        'product_name'       => substr($variant->product->name ?? '', 0, 100),
                        'variant_name'       => $this->buildVariantName($variant),
                        'quantity'           => $qty,
                        'unit_price'         => $variant->price,
                        'line_total'         => $variant->price * $qty,
                    ]);

                    // Inventory ledger entry (audit trail)
                    Inventory::create([
                        'product_variant_id' => $variant->id,
                        'store_location_id'  => $locationId,
                        'checkout_id'        => $checkout->id,
                        'quantity'           => -$qty,
                        'note'               => "Reserved for checkout {$token}",
                    ]);
                }

                return $checkout;
            });

        } catch (RuntimeException $e) {
            return CheckoutResult::error([$e->getMessage()]);
        }

        return CheckoutResult::success($checkout->id);
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    protected function calculateSubtotal(
        array $items,
        Collection $variants
    ): float {
        return collect($items)->sum(function ($item) use ($variants) {
            $variant = $variants->get((int) $item['product_variant_id']);
            return $variant->price * $item['quantity'];
        });
    }

    protected function generateToken(): string
    {
        return strtoupper(Str::random(8)) . '-' . strtoupper(Str::random(8));
    }

    protected function buildVariantName(ProductVariant $variant): ?string
    {
        if (empty($variant->attributes)) {
            return null;
        }

        return substr(
            collect($variant->attributes)
                ->map(fn ($v, $k) => "{$k}: {$v}")
                ->join(', '),
            0,
            100
        );
    }
}
