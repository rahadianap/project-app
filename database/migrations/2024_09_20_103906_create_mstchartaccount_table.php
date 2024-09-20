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
        Schema::create('mstchartaccount', function (Blueprint $table) {
            $table->id();
            $table->string('nomoraccount')->unique();
            $table->string('nama', length: 100);
            $table->unsignedBigInteger('kelompokaccount');
            $table->string(column: 'level', length: 2);
            $table->string(column: 'kasbank', length: 1);
            $table->string(column: 'tipeaccount', length: 10);
            $table->string('userakses', 50)->nullable();
            $table->string('logakses', 50)->nullable();
            $table->boolean('statusupload')->default(false);
            $table->boolean('statusdiperbarui')->default(false);
            $table->boolean('isaktif')->default(true);
            $table->dateTime('tanggalupload')->nullable();
            $table->string('created_by', 20)->nullable();
            $table->string('updated_by', 20)->nullable();
            $table->string('deleted_by', 20)->nullable();

            $table->foreign('kelompokaccount')->references('id')->on('mstkelompokaccount')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mstchartaccount');
    }
};
