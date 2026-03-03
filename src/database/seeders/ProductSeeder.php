<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

use App\Models\Store;
use App\Models\Product;
use App\Models\ProductVariant;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $stores = Store::all();

        if ($stores->isEmpty()) {
            return;
        }

        foreach ($stores as $store) {
            $base = Str::slug($store->name);

            $products = [
                'Pixel One',
                'Pixel One Pro',
                'Pixel Lite',
                'Pixel Ultra',
                'Pixel Fold',
            ];

            foreach ($products as $index => $productName) {
                $product = Product::firstOrCreate(
                    [
                        'store_id' => $store->id,
                        'name' => $productName,
                    ],
                    [
                        'description' => $productName . ' smartphone from ' . $store->name,
                    ]
                );

                // Variants for each product (2-3)
                $variantDefinitions = [
                    [
                        'suffix' => '64gb-black',
                        'price' => 699.00 + $index * 10,
                        'attributes' => [
                            'color' => 'Black',
                            'storage' => '64GB',
                            'ram' => '6GB',
                        ],
                    ],
                    [
                        'suffix' => '128gb-white',
                        'price' => 799.00 + $index * 10,
                        'attributes' => [
                            'color' => 'White',
                            'storage' => '128GB',
                            'ram' => '8GB',
                        ],
                    ],
                    [
                        'suffix' => '256gb-blue',
                        'price' => 899.00 + $index * 10,
                        'attributes' => [
                            'color' => 'Blue',
                            'storage' => '256GB',
                            'ram' => '12GB',
                        ],
                    ],
                ];

                foreach ($variantDefinitions as $variantDef) {
                    $sku = strtoupper($base . '-' . Str::slug($productName) . '-' . $variantDef['suffix']);

                    ProductVariant::updateOrCreate(
                        [
                            'store_id' => $store->id,
                            'sku' => $sku,
                        ],
                        [
                            'product_id' => $product->id,
                            'price' => $variantDef['price'],
                            'attributes' => $variantDef['attributes'],
                            'status' => 'ACTIVE',
                        ]
                    );
                }
            }
        }
    }
}

