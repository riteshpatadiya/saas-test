<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

// Models
use App\Models\Store;
use App\Models\StoreLocation;

class StoreLocationSeeder extends Seeder
{
    public function run(): void
    {
        Store::all()->each(function (Store $store): void {
            $baseName = $store->name;

            $locations = [
                [
                    'name'    => $baseName . ' - Main Branch',
                    'address' => '123 Main Street, Downtown',
                ],
                [
                    'name'    => $baseName . ' - Mall Outlet',
                    'address' => '2nd Floor, Central Mall',
                ],
            ];

            foreach ($locations as $data) {
                StoreLocation::firstOrCreate(
                    [
                        'store_id' => $store->id,
                        'name'     => $data['name'],
                    ],
                    [
                        'address'  => $data['address'],
                    ]
                );
            }
        });
    }
}

