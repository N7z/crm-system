<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'supplier_id',
        'category_id',
        'name',
        'description',
        'buy_price',
        'sell_price',
        'image',
        'quantity',
        'status',
    ];

    public function supplier() {
        return $this->belongsTo(Supplier::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function getBuyPriceFormattedAttribute()
    {
        return 'R$ ' . number_format($this->buy_price, 2, ',', '.');
    }

    public function getSellPriceFormattedAttribute()
    {
        return 'R$ ' . number_format($this->sell_price, 2, ',', '.');
    }
}
