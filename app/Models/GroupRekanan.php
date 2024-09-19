<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use App\Models\Rekanan;

class GroupRekanan extends Model
{
    use HasFactory, HasRoles, SoftDeletes;
    use HasPanelShield;

    protected $table = 'dbo.mstgrouprekanan';

    protected $guard_name = 'web';

    protected $fillable = [
        'nama',
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

    public function group_suppliers(): HasMany
    {
        return $this->hasMany(Rekanan::class);
    }
}
