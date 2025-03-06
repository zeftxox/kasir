<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('detail_penjualan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_penjualan')->constrained('penjualans')->onDelete('cascade');
            $table->foreignId('id_products')->constrained('products')->onDelete('cascade');
            $table->decimal('harga_jual', 15, 2);
            $table->integer('qty');
            $table->decimal('subtotal', 15, 2);
            $table->date('tanggal_penjualan');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('detail_penjualan');
    }
};
