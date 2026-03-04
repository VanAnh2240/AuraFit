<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'code';
    protected $keyType    = 'string';
    public $incrementing  = false;

    protected $fillable = [
        'code', 'name', 'name_en', 'full_name', 'full_name_en',
        'code_name', 'administrative_unit_id', 'administrative_region_id',
    ];

    public function districts()
    {
        return $this->hasMany(District::class, 'province_code', 'code');
    }

    public function administrativeUnit()
    {
        return $this->belongsTo(AdministrativeUnit::class, 'administrative_unit_id');
    }
}