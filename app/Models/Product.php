<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Permission\Traits\HasRoles;
use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use App\Models\Category;

class Product extends Model
{
    use HasFactory, SoftDeletes, HasRoles;
    use HasPanelShield;

    protected $table = 'dbo.mstbarang';

    protected $fillable = [
        'kode',
        'kodebarcode',
        'nama',
        'namaalias',
        'merk',
        'satuan',
        'kategori',
        'ukuran',
        'pajak',
        'userakses',
        'logakses',
        'statusupload',
        'statusdiperbarui',
        'tanggalupload',
        'isaktif',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'pajak' => 'boolean',
        'statusupload' => 'boolean',
        'statusdiperbarui' => 'boolean',
        'nonaktif' => 'boolean'
    ];

    public function detail_barang(): HasOne
    {
        return $this->hasOne(DetailProduct::class, 'id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class, 'satuan');
    }
}