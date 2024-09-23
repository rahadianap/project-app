<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Permission\Traits\HasRoles;
use BezhanSalleh\FilamentShield\Traits\HasPanelShield;

class Toko extends Model
{
    use HasFactory, SoftDeletes, HasRoles;
    use HasPanelShield;

    protected $table = 'dbo.msttoko';

    protected $fillable = [
        'kode',
        'wilayah_id',
        'npwp',
        'nama',
        'alamat',
        'tgl_pengukuhan',
        'notelepon',
        'nowa',
        'email',
        'fb',
        'ig',
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

    public function region(): BelongsTo
    {
        return $this->belongsTo(Wilayah::class, 'wilayah_id');
    }
}
