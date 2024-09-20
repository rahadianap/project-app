<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Permission\Traits\HasRoles;
use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChartAccount extends Model
{
    use HasFactory, SoftDeletes, HasRoles;
    use HasPanelShield;

    protected $table = 'dbo.mstchartaccount';

    protected $guard_name = 'web';

    protected $fillable = [
        'nomoraccount',
        'nama',
        'kelompokaccount',
        'level',
        'kasbank',
        'tipeaccount',
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

    public function group_coa(): BelongsTo
    {
        return $this->belongsTo(KelompokAccount::class, 'kelompokaccount');
    }

    public function details(): HasMany
    {
        return $this->hasMany(DetailChartAccount::class);
    }
}
