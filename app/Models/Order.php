<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $fillable = ['user_id', 'product_id', 'jumlah', 'total_harga', 'catatan', 'status', 'alasan_tolak', 'metode_bayar', 'tipe_penyerahan'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function totalhargaFormatted()
    {
        return 'Rp ' . number_format($this->total_harga, 0, ',', '.');
    }

    public function statusColor()
    {
        return match ($this->status) {
            'menunggu konfirmasi' => 'bg-yellow-100 text-yellow-800',
            'diproses' => 'bg-blue-100 text-blue-800',
            'selesai' => 'bg-green-100 text-green-800',
            'ditolak' => 'bg-red-100 text-red-800',
        };
    }

    public function statusLabel()
    {
        return match ($this->status) {
            'menunggu konfirmasi' => 'Menunggu Konfirmasi',
            'diproses' => 'Sedang Diproses',
            'selesai' => 'Selesai',
            'ditolak' => 'Ditolak',
        };
    }
}
