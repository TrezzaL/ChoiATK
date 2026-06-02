<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderBaruNotification extends Notification
{
    use Queueable;

    protected $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        // Ambil data keranjang saat ini milik user sebelum dihapus, atau ambil ringkasan yang dikirim controller
        // Biar praktis dan gak numpuk, kita langsung baca data dari order pertama yang dikirim dari CartController
        $user = $this->order->user;

        // Mengambil orderan yang dibuat bersamaan dalam waktu yang sangat dekat (detik yang sama)
        $items = \App\Models\Order::where('user_id', $this->order->user_id)
                    ->where('created_at', $this->order->created_at)
                    ->with('product')
                    ->get();

        $ringkasan = [];
        foreach ($items as $item) {
            if ($item->product) {
                $ringkasan[] = $item->product->nama . ' (' . $item->jumlah . 'x)';
            }
        }
        $daftarProduk = implode(', ', $ringkasan);

        return [
            'order_id' => $this->order->id,
            'nama_pelanggan' => $user->name,
            'total_bayar' => $this->order->total_harga,
            'pesan' => 'Ada pesanan baru dari ' . $user->name . ': ' . $daftarProduk . ' dengan total Rp ' . number_format($this->order->total_harga, 0, ',', '.'),
            'url' => route('admin.order.show', $this->order->id), // UBAH 'link' MENJADI 'url'
        ];
    }
}
