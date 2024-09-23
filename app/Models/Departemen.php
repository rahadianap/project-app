<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Permission\Traits\HasRoles;
use BezhanSalleh\FilamentShield\Traits\HasPanelShield;

class Departemen extends Model
{
    use HasFactory, SoftDeletes, HasRoles;
    use HasPanelShield;

    protected $table = 'dbo.mstdepartement';

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
}
