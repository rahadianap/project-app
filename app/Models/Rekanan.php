<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
use BezhanSalleh\FilamentShield\Traits\HasPanelShield;

class Rekanan extends Model
{
    use HasFactory, HasRoles, SoftDeletes;
    use HasPanelShield;

    protected $table = 'dbo.mstrekanan';

    protected $guard_name = 'web';

    public function group(): BelongsTo
    {
        return $this->BelongsTo(GroupRekanan::class, 'group_id');
    }

    protected $fillable = [
        'kode',
        'no_ktp',
        'npwp',
        'nama',
        'alamat',
        'tgl_lahir',
        'no_hp1',
        'no_hp2',
        'provinsi_id',
        'kota_id',
        'kecamatan_id',
        'kelurahan_id',
        'email',
        'group_id',
        'agama',
        'pendidikan',
        'pekerjaan',
        'keterangan',
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

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_rekanan', 'product_id')
            ->withPivot('product_id');
    }
}
