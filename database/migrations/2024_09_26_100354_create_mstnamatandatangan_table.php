<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mstnamatandatangan', function (Blueprint $table) {
            $table->id();
            $table->string('id_pengenal')->unique();
            $table->string('nama')->nullable();
            $table->string('alamat')->nullable();
            $table->unsignedBigInteger('jabatan_id')->nullable();
            $table->string('nama_bank');
            $table->string('rekening_bank');
            $table->unsignedBigInteger('wilayah_id')->nullable();
            $table->unsignedBigInteger('toko_id')->nullable();
            $table->string('userakses', 50)->nullable();
            $table->string('logakses', 50)->nullable();
            $table->boolean('statusupload')->default(false);
            $table->boolean('statusdiperbarui')->default(false);
            $table->boolean('isaktif')->default(true);
            $table->dateTime('tanggalupload')->nullable();
            $table->string('created_by', 20)->nullable();
            $table->string('updated_by', 20)->nullable();
            $table->string('deleted_by', 20)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign(columns: 'jabatan_id')->references('id')->on('mstjabatan');
            $table->foreign(columns: 'wilayah_id')->references('id')->on('mstwilayah');
            $table->foreign(columns: 'toko_id')->references('id')->on('msttoko');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mstnamatandatangan');
    }
};
