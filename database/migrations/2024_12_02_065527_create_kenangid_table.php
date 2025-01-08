<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  public function up()
    {
        Schema::create('kenang_ids', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('media')->nullable();
            $table->string('media_size')->nullable();
            $table->string('size')->nullable();
            $table->string('type')->default('public');
            $table->text('caption')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kenang_ids');
    }
};
