<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategorySub extends Model
{
    protected $table      = 'category_sub';
    protected $primaryKey = 'category_sub_id';
    public    $keyType    = 'string';
    public    $incrementing = false;
    public    $timestamps   = false;

    protected $fillable = [
        'category_sub_id',
        'category_id',
        'category_sub_name',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    public function products()
    {
        return $this->hasMany(product::class, 'category_sub_id', 'category_sub_id');
    }
}