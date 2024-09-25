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
        Schema::create('mstpegawai', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 30)->unique();
            $table->unsignedBigInteger('wilayah_id')->nullable();
            $table->unsignedBigInteger('toko_id')->nullable();
            $table->unsignedBigInteger('departemen_id')->nullable();
            $table->unsignedBigInteger('jabatan_id')->nullable();
            $table->string('nama', 50);
            $table->string('alamat')->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->date('tgl_gabung')->nullable();
            $table->string('pendidikan', 10);
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

            $table->foreign('wilayah_id')->references('id')->on('mstwilayah');
            $table->foreign('toko_id')->references('id')->on('msttoko');
            $table->foreign('departemen_id')->references('id')->on('mstdepartement');
            $table->foreign('jabatan_id')->references('id')->on('mstjabatan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mstpegawai');
    }
};
