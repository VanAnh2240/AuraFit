<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $table      = 'product_image';
    protected $primaryKey = null;
    public    $incrementing = false;
    public    $timestamps   = false;

    protected $fillable = [
        'product_id',
        'image_link',
        'color_code',
    ];

    public function product()
    {
        return $this->belongsTo(product::class, 'product_id', 'product_id');
    }
}