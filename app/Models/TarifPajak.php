<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use BezhanSalleh\FilamentShield\Traits\HasPanelShield;

class TarifPajak extends Model
{
    use HasFactory, SoftDeletes, HasRoles;
    use HasPanelShield;

    protected $table = 'dbo.msttarifpajak';

    protected $fillable = [
        'wilayah_id',
        'toko_id',
        'ppn',
        'ppnbm',
        'pphfinal',
        'pphpsl21',
        'pphpsl22',
        'pphpsl23',
        'pphpsl24',
        'pphpsl25',
        'pphpsl26',
        'pphpsl29',
        'penanda',
        'is_journal',
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

    public function wilayah(): BelongsTo
    {
        return $this->belongsTo(Wilayah::class, 'wilayah_id');
    }

    public function toko(): BelongsTo
    {
        return $this->belongsTo(Toko::class, 'toko_id');
    }
}
