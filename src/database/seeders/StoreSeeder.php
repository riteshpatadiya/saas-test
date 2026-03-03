<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

// Models
use App\Models\Store;

class StoreSeeder extends Seeder
{
    public function run(): void
    {
        $stores = [
            [
                'name' => 'Pixel Mobile',
                'slug' => 'pixel-mobile',
            ],
            [
                'name' => 'Galaxy Mobile',
                'slug' => 'galaxy-mobile',
            ],
        ];

        foreach ($stores as $data) {
            Store::firstOrCreate(
                ['slug' => $data['slug']],
                ['name' => $data['name']]
            );
        }
    }
}
