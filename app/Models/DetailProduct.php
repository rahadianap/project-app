<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Permission\Traits\HasRoles;
use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use App\Models\Product;

class DetailProduct extends Model
{
    use HasFactory, SoftDeletes, HasRoles;
    use HasPanelShield;

    protected $table = 'dbo.mstdetailbarang';

    protected $fillable = [
        'product_id',
        'wilayah_id',
        'toko_id',
        'saldoawal',
        'hargajualkarton',
        'hargajualeceran',
        'hargabelikarton',
        'hargabelieceran',
        'hargapokokavgkarton',
        'hargapokokavgeceran',
        'hargapokokfifokarton',
        'hargapokokfifoeceran',
        'userakses',
        'logakses',
        'statusupload',
        'statusdiperbarui',
        'isaktif',
        'tanggalupload',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    protected $casts = [
        'statusupload' => 'boolean',
        'statusdiperbarui' => 'boolean',
        'nonaktif' => 'boolean'
    ];

    public function barang(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function db_wilayah(): BelongsTo
    {
        return $this->belongsTo(Wilayah::class, 'wilayah_id');
    }

    public function db_toko(): BelongsTo
    {
        return $this->belongsTo(Toko::class, 'toko_id');
    }
}
