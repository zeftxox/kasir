<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('penjualans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->constrained('users');
            $table->foreignId('id_customer')->nullable()->constrained('customers')->nullOnDelete();
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('total_harga', 15, 2);
            $table->decimal('penyesuaian', 10, 2)->default(0);
            $table->decimal('total_bayar', 15, 2);
            $table->decimal('nominal_bayar', 15, 2);
            $table->decimal('kembalian', 15, 2);
            $table->timestamp('tanggal_penjualan')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->boolean('isDeleted')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('penjualans');
    }
};
