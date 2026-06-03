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
        return $this->belongsTo(Product::class); //relasi antara Cart dan Product, menunjukkan bahwa setiap item dalam keranjang terkait dengan satu produk tertentu. Dengan menggunakan belongsTo, kita dapat mengakses informasi produk yang terkait dengan item keranjang tersebut.
    }

    public function user()
    {
        return $this->belongsTo(User::class); // setiap user dapat memiliki banyak item dalam keranjang, tetapi setiap item dalam keranjang hanya terkait dengan satu user tertentu. Dengan menggunakan belongsTo, kita dapat mengakses informasi pengguna yang terkait dengan item keranjang tersebut.
    } 
}
