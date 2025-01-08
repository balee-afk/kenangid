<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StorageSize;
use App\Models\User;

class StorageSizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('usertype', 'user')->get();

        foreach ($users as $user) {
            StorageSize::create([
                'user_id' => '3',
                'current_size' => 1024, // Awalnya kosong
                'purchase_date' => now(),
                'expiry_date' => now()->addMonths(1),
            ]);
        }
    }
}
