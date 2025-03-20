<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->enum('user_level', ['admin', 'officer']);
            $table->string('username')->unique();
            $table->string('password');
            $table->text('alamat')->nullable();
            $table->string('no_handphone', 15)->nullable();
            $table->boolean('isDeleted')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
