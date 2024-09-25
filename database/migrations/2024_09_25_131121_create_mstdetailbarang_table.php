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
        Schema::create('mstdetailbarang', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedBigInteger('wilayah_id')->nullable();
            $table->unsignedBigInteger('toko_id')->nullable();
            $table->bigInteger('saldoawal');
            $table->decimal('hargajualkarton', 10, 2)->nullable();
            $table->decimal('hargajualeceran', 10, 2)->nullable();
            $table->decimal('hargabelikarton', 10, 2)->nullable();
            $table->decimal('hargabelieceran', 10, 2)->nullable();
            $table->decimal('hargapokokavgkarton', 10, 2)->nullable();
            $table->decimal('hargapokokavgeceran', 10, 2)->nullable();
            $table->decimal('hargapokokfifokarton', 10, 2)->nullable();
            $table->decimal('hargapokokfifoeceran', 10, 2)->nullable();
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

            $table->foreign('wilayah_id')->references('id')->on('mstwilayah')->onDelete('cascade');
            $table->foreign('toko_id')->references('id')->on('msttoko');
            $table->foreign('product_id')->references('id')->on('mstbarang');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mstdetailbarang');
    }
};
