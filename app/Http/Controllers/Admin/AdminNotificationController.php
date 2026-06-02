<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; // Pastikan untuk mengimpor Request untuk membuat fungsi yang diperlukan
use App\Models\Order; // Pastikan untuk mengimpor model Order

class AdminNotificationController extends Controller
{
    // Fungsi untuk menandai notifikasi sebagai sudah dibaca
    public function read($id) // Pastikan untuk menerima parameter $id untuk mencari notifikasi yang tepat
    {
        // Cari notifikasi berdasarkan ID dan pastikan itu milik pengguna yang sedang login
        $notification = auth()->user()->notifications()->findOrFail($id);

        // Setelah itu Tandai notifikasi sebagai sudah dibaca
        $notification->markAsRead();

        // Cek apakah pakai 'link' (OrderBaru) atau 'url' (OrderNotification)
        $destinationLink = $notification->data['link'] ?? ($notification->data['url'] ?? route('admin.dashboard'));

        return redirect($destinationLink);
    }
}
