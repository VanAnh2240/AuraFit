<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table      = 'product';
    protected $primaryKey = 'product_id';
    public    $keyType    = 'string';
    public    $incrementing = false;
    public    $timestamps   = false;

    protected $fillable = [
        'product_id',
        'category_sub_id',
        'name',
        'price',
        'description',
        'composition',
        'is_selling',
    ];

    // ── Quan hệ ──────────────────────────────────────────────────────

    /**
     * Ảnh sản phẩm (product_image)
     * product_id → product_image.product_id
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'product_id');
    }

    /**
     * Màu sắc — Many-to-Many qua bảng product_color
     * product_id ←→ color.color_code
     */
    public function colors()
    {
        return $this->belongsToMany(
            Color::class,        // Model đích
            'product_color',     // Bảng pivot
            'product_id',        // FK của model này trong pivot
            'color_code',        // FK của model đích trong pivot
            'product_id',        // PK của model này
            'color_code'         // PK của model đích
        );
    }

    /**
     * Danh mục con
     */
    public function categorySub()
    {
        return $this->belongsTo(CategorySub::class, 'category_sub_id', 'category_sub_id');
    }
}