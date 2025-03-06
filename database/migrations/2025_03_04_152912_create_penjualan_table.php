<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('penjualans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
            $table->foreignId('id_customer')->constrained('customers')->onDelete('cascade')->nullable();
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('total_harga', 15, 2);
            $table->decimal('penyesuaian', 10, 2)->default(0);
            $table->decimal('total_bayar', 15, 2);
            $table->decimal('kembalian', 15, 2);
            $table->date('tanggal_penjualan');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('penjualans');
    }
};
