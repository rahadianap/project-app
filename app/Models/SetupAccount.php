<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use BezhanSalleh\FilamentShield\Traits\HasPanelShield;

class SetupAccount extends Model
{
    use HasFactory, SoftDeletes, HasRoles;
    use HasPanelShield;

    protected $table = 'dbo.mstsetupaccountotomatis';

    protected $fillable = [
        'chart_account_id',
        'jenistransaksi',
        'posisidebet',
        'posisikredit',
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

    public function sa_coa(): BelongsTo
    {
        return $this->belongsTo(ChartAccount::class, 'chart_account_id');
    }
}
