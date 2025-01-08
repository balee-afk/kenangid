<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaction;
use App\Models\User;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('usertype', 'user')->first();

        // Transaksi upgrade storage
        Transaction::create([
            'user_id' => '3',
            'transaction_type' => 'upgrade',
            'proof' => 'proof.png',
            'amount' => 50000,
            'transaction_date' => now(),
        ]);
    }
}
