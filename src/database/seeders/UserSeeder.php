<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Store;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User
        User::updateOrCreate(
            ['email' => 'admin@rpsaastest.com'],
            [
                'name' => 'System Admin',
                'password' => Hash::make('password'),
                'role' => User::ROLE_ADMIN,
                'store_id' => null,
            ]
        );

        // Create 2-3 users for each store
        Store::all()->each(function (Store $store): void {
            $baseSlug = $store->slug ?: 'store-' . $store->id;

            $users = [
                [
                    'email' => $baseSlug . '+owner@example.com',
                    'name' => $store->name . ' Owner',
                ],
                [
                    'email' => $baseSlug . '+manager@example.com',
                    'name' => $store->name . ' Manager',
                ],
                [
                    'email' => $baseSlug . '+support@example.com',
                    'name' => $store->name . ' Support',
                ],
            ];

            foreach ($users as $userData) {
                User::updateOrCreate(
                    ['email' => $userData['email']],
                    [
                        'name' => $userData['name'],
                        'password' => Hash::make('password'),
                        'role' => User::ROLE_STORE,
                        'store_id' => $store->id,
                    ]
                );
            }
        });
    }
}