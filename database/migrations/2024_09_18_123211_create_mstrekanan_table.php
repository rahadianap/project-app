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
        Schema::create('mstrekanan', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 30);
            $table->string('no_ktp', 16)->unique();
            $table->string('npwp', length: 100);
            $table->string('nama', 100);
            $table->text('alamat')->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->string('no_hp1', 12);
            $table->string('no_hp2', 12)->nullable();
            $table->unsignedBigInteger('provinsi_id')->nullable();
            $table->unsignedBigInteger('kota_id')->nullable();
            $table->unsignedBigInteger('kecamatan_id')->nullable();
            $table->unsignedBigInteger('kelurahan_id')->nullable();
            $table->string('email')->nullable();
            $table->unsignedBigInteger('group_id')->nullable();
            $table->string('agama', 100)->nullable();
            $table->string('pendidikan', 100)->nullable();
            $table->string('pekerjaan', 100)->nullable();
            $table->string('keterangan')->nullable();
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

            $table->foreign(columns: 'provinsi_id')->references('id')->on('mstprovinsi');
            $table->foreign(columns: 'kota_id')->references('id')->on('mstkotakabupaten');
            $table->foreign(columns: 'kecamatan_id')->references('id')->on('mstkecamatan');
            $table->foreign(columns: 'kelurahan_id')->references('id')->on('mstkelurahandesa');
            $table->foreign(columns: 'group_id')->references('id')->on('mstgrouprekanan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mstrekanan');
    }
};
