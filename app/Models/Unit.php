<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dbo.mstsatuan';

    protected $fillable = [
        'unit_code',
        'unit_name',
        'unit_description'
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}