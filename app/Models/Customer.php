<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Hash;

class Customer extends Model implements Authenticatable
{
    use HasFactory;

    protected $table = 'customer';
    public $timestamps = false;
    protected $primaryKey = 'CUSTOMER_ID';

    protected $fillable = [
        'USERNAME',
        'EMAIL',
        'PASSWORD',
        'CART_ID',
        'WISHLIST_ID',
        'BIRTHDAY',
        'WEIGHT',
        'HEIGHT',
        'UNDERTONE',
        'PERSONAL_COLOR',
        'FAVORITE_STYLES',
        'PORTRAIT_PHOTO',
    ];

    // Accessor: tính tuổi từ BIRTHDAY
    public function getAgeAttribute(): ?int
    {
        if (!$this->BIRTHDAY) return null;
        return \Carbon\Carbon::parse($this->BIRTHDAY)->age;
    }

    // Accessor: decode favorite styles từ JSON
    public function getFavoriteStylesListAttribute(): array
    {
        if (!$this->FAVORITE_STYLES) return [];
        return json_decode($this->FAVORITE_STYLES, true) ?? [];
    }

    public static function paginate(int $int) {}

    public function getAuthIdentifierName() { return 'CUSTOMER_ID'; }
    public function getAuthIdentifier(): string { return $this->CUSTOMER_ID; }
    public function getAuthPassword() { return Hash::make($this->PASSWORD); }
    public function getRememberToken() { return null; }
    public function setRememberToken($value) { return null; }
    public function getRememberTokenName() { return null; }

    public function cart()
    {
        return $this->hasOne(Cart::class, 'CART_ID', 'CART_ID');
    }
}