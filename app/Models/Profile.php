<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table = 'profile';

    // PK là customer_id, không auto-increment
    protected $primaryKey = 'customer_id';
    public $incrementing  = false;
    protected $keyType    = 'int';

    protected $fillable = [
        'customer_id',
        'weight',
        'height',
        'body_shape',
        'undertone',
        'personal_color',
        'favorite_styles',
        'portrait_image',
    ];

    protected $casts = [
        'favorite_styles' => 'array',
        'weight'          => 'float',
        'height'          => 'float',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'CUSTOMER_ID');
    }
}