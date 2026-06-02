<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'carts'; //protected untuk mendefinisikan nama tabel yang digunakan oleh model ini, jika tidak sesuai dengan konvensi Laravel (karena Laravel mengasumsikan nama tabel adalah bentuk jamak dari nama model, yaitu 'carts' untuk model 'Cart')
    protected $fillable = [
        'user_id',
        'product_id',
        'jumlah',
        'total_harga',
        'status',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
