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
        Schema::create('mstform', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->unique();
            $table->unsignedBigInteger('departemen_id')->nullable();
            $table->string(column: 'keterangan');
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

            $table->foreign(columns: 'departemen_id')->references('id')->on('mstdepartement')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mstform');
    }
};
