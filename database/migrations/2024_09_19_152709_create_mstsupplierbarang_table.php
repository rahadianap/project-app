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
        Schema::create('product_rekanan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rekanan_id');
            $table->unsignedBigInteger('product_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('rekanan_id')->references('id')->on('mstrekanan')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('mstbarang')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_rekanan');
    }
};
