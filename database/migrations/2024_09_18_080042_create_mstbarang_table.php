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
        Schema::create('mstbarang', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 30);
            $table->string('kodebarcode', length: 30);
            $table->string('nama', length: 100);
            $table->string('namaalias', 100)->nullable();
            $table->string('merk', 20)->nullable();
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('ukuran', 20)->nullable();
            $table->boolean('pajak')->default(false);
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

            $table->foreign('category_id')->references('id')->on('mstkategoribarang')->onDelete('cascade');
            $table->foreign('unit_id')->references('id')->on('mstsatuan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mstbarang');
    }
};
