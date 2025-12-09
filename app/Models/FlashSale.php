<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlashSale extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'discount_price', 'stock'];

    // Relasi: Flash Sale itu pasti punya Produk Asli
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}