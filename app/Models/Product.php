<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = ['category_id', 'nama', 'deskripsi', 'harga', 'stok', 'stok_minimum', 'foto', 'is_aktif'];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function stokMenipis()
    {
        return $this->stok <= $this->stok_minimum;
    }

    public function hargaFormatted()
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
