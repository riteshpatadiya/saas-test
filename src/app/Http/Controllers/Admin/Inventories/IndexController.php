<?php

namespace App\Http\Controllers\Admin\Inventories;

use App\Http\Controllers\Controller;

// Models
use Illuminate\Support\Facades\DB;
use App\Models\ProductVariant;
use App\Models\Product;
use App\Models\Store;
use App\Models\StoreLocation;
use App\Models\Inventory;

class IndexController extends Controller
{
    public function __invoke()
    {
        $storeId = request('store_id');
        $productId = request('product_id');

        $stores = Store::orderBy('name')->get();
        $productsQuery = Product::query()->orderBy('name');

        if ($storeId) {
            $productsQuery->where('store_id', $storeId);
        }

        $products = $productsQuery->get();

        $variantStockQuery = ProductVariant::query()
            ->leftJoin('inventories', 'inventories.product_variant_id', '=', 'product_variants.id')
            ->leftJoin('products', 'products.id', '=', 'product_variants.product_id')
            ->leftJoin('stores', 'stores.id', '=', 'product_variants.store_id')
            ->select([
                'product_variants.id',
                'product_variants.sku',
                'product_variants.status',
                'product_variants.price',
                'products.name as product_name',
                'stores.name as store_name',
                DB::raw('COALESCE(SUM(inventories.quantity), 0) as total_stock'),
            ]);

        if ($storeId) {
            $variantStockQuery->where('product_variants.store_id', $storeId);
        }

        if ($productId) {
            $variantStockQuery->where('product_variants.product_id', $productId);
        }

        $variantStocks = $variantStockQuery
            ->groupBy(
                'product_variants.id',
                'product_variants.sku',
                'product_variants.status',
                'product_variants.price',
                'products.name',
                'stores.name',
            )
            ->orderBy('product_variants.id', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.inventories.index', [
            'stores'        => $stores,
            'products'      => $products,
            'variantStocks' => $variantStocks,
        ]);
    }
}

