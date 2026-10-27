<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;

    protected $table = 'divisas';

    protected $fillable = [
        'name',
        'symbol',
        'exchange_rate'
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'currency_id');
    }

    public function productPrices()
    {
        return $this->hasMany(ProductPrice::class, 'currency_id');
    }
}