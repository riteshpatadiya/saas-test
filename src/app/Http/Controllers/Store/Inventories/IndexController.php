<?php

namespace App\Http\Controllers\Store\Inventories;

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
        $storeId = app('currentStore')->id;
        $productId = (int) request('product_id');

        $productsQuery = Product::where('store_id', $storeId)->orderBy('name');

        $products = $productsQuery->get();

        $variantStockQuery = ProductVariant::query()
            ->leftJoin('inventories', 'inventories.product_variant_id', '=', 'product_variants.id')
            ->leftJoin('products', 'products.id', '=', 'product_variants.product_id')
            ->leftJoin('stores', 'stores.id', '=', 'product_variants.store_id')
            ->where('product_variants.store_id', $storeId)
            ->when($productId > 0, function ($query) use ($productId) {
                $query->where('product_variants.product_id', $productId);
            })
            ->select([
                'product_variants.id',
                'product_variants.sku',
                'product_variants.status',
                'product_variants.price',
                'products.name as product_name',
                'stores.name as store_name',
                DB::raw('COALESCE(SUM(inventories.quantity), 0) as total_stock'),
            ]);

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

        return view('store.inventories.index', [
            'products'      => $products,
            'variantStocks' => $variantStocks,
        ]);
    }
}

