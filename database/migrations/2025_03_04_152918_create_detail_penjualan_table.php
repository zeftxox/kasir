<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up()
    {
        Schema::create('detail_penjualans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_penjualan')->constrained('penjualans')->onDelete('cascade');
            $table->foreignId('id_products')->constrained('products')->onDelete('cascade');
            $table->decimal('harga_jual', 15, 2);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('harga_discount', 15, 2);
            $table->integer('qty');
            $table->decimal('subtotal', 15, 2);
            $table->timestamp('tanggal_penjualan')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('detail_penjualan');
    }
};
