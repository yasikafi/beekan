<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Izinkan kolom-kolom ini diisi data
    protected $fillable = [
        'user_id', 
        'name', 
        'price', 
        'description', 
        'stock', 
        'image_color'
    ];

    // Relasi: Produk ini milik siapa? (Milik User/Seller)
    public function seller()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}