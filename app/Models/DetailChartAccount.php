<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Permission\Traits\HasRoles;
use BezhanSalleh\FilamentShield\Traits\HasPanelShield;

class DetailChartAccount extends Model
{
    use HasFactory, SoftDeletes, HasRoles;
    use HasPanelShield;

    protected $table = 'dbo.mstdetailchartaccount';

    protected $fillable = [
        'nomoraccount',
        'posisi',
        'kodetoko',
        'kodewilayah',
        'saldoawal',
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

    public function coa(): BelongsTo
    {
        return $this->belongsTo(ChartAccount::class, 'nomoraccount');
    }
}
