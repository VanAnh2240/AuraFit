<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $table      = 'color';
    protected $primaryKey = 'color_code';
    public    $keyType    = 'int';
    public    $incrementing = false;
    public    $timestamps   = false;

    protected $fillable = [
        'color_code',
        'type_en',
        'color_name_en',
        'type_vi',
        'color_name_vi',
    ];

    public function products()
    {
        return $this->belongsToMany(
            product::class,
            'product_color',
            'color_code',
            'product_id',
            'color_code',
            'product_id'
        );
    }
}