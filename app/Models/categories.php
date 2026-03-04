<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class categories extends Model
{
    use HasFactory;
    protected $table = 'categories';
    protected $primaryKey = 'categories_NAME';
    protected $keyType = 'string'; 
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = ['categories_NAME'];

    public function products()
    {
        return $this->belongsToMany(product::class, 'product_belong', 'categories_NAME', 'product_ID');
    }
}
