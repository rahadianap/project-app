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
        Schema::create('msttarifpajak', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('wilayah_id')->nullable();
            $table->unsignedBigInteger('toko_id')->nullable();
            $table->integer('ppn')->nullable();
            $table->integer('ppnbm')->nullable();
            $table->integer('pphfinal')->nullable();
            $table->integer('pphpsl21')->nullable();
            $table->integer('pphpsl22')->nullable();
            $table->integer('pphpsl23')->nullable();
            $table->integer('pphpsl24')->nullable();
            $table->integer('pphpsl25')->nullable();
            $table->integer('pphpsl26')->nullable();
            $table->integer('pphpsl29')->nullable();
            $table->integer('penanda')->nullable();
            $table->boolean('is_journal')->nullable()->default(false);
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
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('msttarifpajak');
    }
};
