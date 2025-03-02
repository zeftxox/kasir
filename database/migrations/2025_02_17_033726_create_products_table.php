<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_kategori');
            $table->foreign('id_kategori')->references('id')->on('categories')->onDelete('cascade');
            $table->string('nama_produk');
            $table->decimal('harga_jual', 12, 2);
            $table->decimal('harga_beli', 12, 2);
            $table->bigInteger('stok');
            $table->char('barcode', 13)->unique();
            $table->timestamps();
            $table->boolean('isDeleted')->default(false);
        });
    }

    /**
     * Reverse the migrations (Rollback Handler).
     */
    public function down(): void
    {
        // Cek apakah tabel 'products' masih ada sebelum rollback
        if (Schema::hasTable('products')) {
            // Hapus foreign key terlebih dahulu untuk menghindari error
            Schema::table('products', function (Blueprint $table) {
                $table->dropForeign(['id_kategori']); // Hapus foreign key
            });

            // Backup data sebelum rollback (opsional, jika ingin menyimpan data sebelum rollback)
            DB::table('products')->delete(); // Kosongkan tabel tanpa menghapus struktur
            
            // Alternatif: Bisa mengganti ini dengan penyimpanan sementara jika diperlukan
            // $products = DB::table('products')->get();
            // file_put_contents(storage_path('backup_products.json'), json_encode($products));

            // Ubah tabel tanpa menghapusnya
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn(['harga_jual', 'harga_beli']); // Contoh: Hapus kolom tambahan jika rollback
            });
        }
    }
};
