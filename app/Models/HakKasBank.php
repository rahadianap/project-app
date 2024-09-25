<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HakKasBank extends Model
{
    use HasFactory, SoftDeletes, HasRoles;
    use HasPanelShield;

    protected $table = 'dbo.msthakkasbank';

    protected $guard_name = 'web';

    protected $fillable = [
        'pegawai_id',
        'chart_account_id',
        'wilayah_id',
        'toko_id',
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

    public function hkb_pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }


    public function hkb_coa(): BelongsTo
    {
        return $this->belongsTo(ChartAccount::class, 'chart_account_id');
    }


    public function hkb_wilayah(): BelongsTo
    {
        return $this->belongsTo(Wilayah::class, 'wilayah_id');
    }

    public function hkb_toko(): BelongsTo
    {
        return $this->belongsTo(Toko::class, 'toko_id');
    }
}
