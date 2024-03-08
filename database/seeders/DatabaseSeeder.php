<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Admin Goy',
            'email' => 'admingoy@gmail.com',
            'username' => 'admingoy',
            'phone' => '087777711022',
            'roles' => 'ADMIN',
            'password' => Hash::make('admin123'),
        ]);
    }
}
