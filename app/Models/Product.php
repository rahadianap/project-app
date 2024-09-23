<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Permission\Traits\HasRoles;
use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use App\Models\Category;

class Product extends Model
{
    use HasFactory, SoftDeletes, HasRoles;
    use HasPanelShield;

    protected $table = 'dbo.mstbarang';

    protected $guard_name = 'web';

    protected $fillable = [
        'kode',
        'kodebarcode',
        'nama',
        'namaalias',
        'merk',
        'unit_id',
        'category_id',
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
        'isaktif' => 'boolean'
    ];

    public function details(): HasMany
    {
        return $this->hasMany(DetailProduct::class, 'id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function rekanans(): BelongsToMany
    {
        return $this->belongsToMany(Rekanan::class);
    }
}