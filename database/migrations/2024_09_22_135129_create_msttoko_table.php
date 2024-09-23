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
        Schema::create('msttoko', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 20)->unique();
            $table->unsignedBigInteger('wilayah_id')->nullable();
            $table->string('npwp', 50)->nullable();
            $table->string('nama', 50);
            $table->string('alamat', 150)->nullable();
            $table->dateTime('tgl_pengukuhan')->nullable();
            $table->string('notelepon', 15)->nullable();
            $table->string('nowa', 15)->nullable();
            $table->string('email', 15)->nullable();
            $table->string('fb', 15)->nullable();
            $table->string('ig', 15)->nullable();
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
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('msttoko');
    }
};
