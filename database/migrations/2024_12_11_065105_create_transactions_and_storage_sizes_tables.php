<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsAndStorageSizesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Tabel transactions
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Relasi ke tabel users
            $table->string('transaction_type'); // Contoh: 'upgrade', 'renew'
            $table->string('proof'); 
            $table->string('status')->default('pending');
            $table->decimal('amount', 10, 2); // Jumlah transaksi
            $table->dateTime('transaction_date'); // Tanggal transaksi
            $table->timestamps();

            // Foreign key ke users
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        // Tabel storage_sizes
        Schema::create('storage_sizes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Relasi ke tabel users
            $table->integer('current_size')->default(1024); // Ukuran storage dalam MB (default 1 GB)
            $table->dateTime('purchase_date'); // Tanggal pembelian upgrade
            $table->dateTime('expiry_date'); // Tanggal kadaluarsa upgrade
            $table->timestamps();

            // Foreign key ke users
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('storage_sizes');
        Schema::dropIfExists('transactions');
    }
}
