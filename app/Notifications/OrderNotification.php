<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderNotification extends Notification
{
    use Queueable;
    private $data;

    /**
     * Create a new notification instance.
     */
    public function __construct($data)
    {
        $this->data = $data; // Menyimpan data yang diterima dari CartController ke dalam properti $data
        // untuk digunakan nanti saat membuat pesan notifikasi. Dengan cara ini, kita bisa mengakses
        // informasi seperti pesan notifikasi dan URL yang terkait saat menyusun pesan notifikasi.
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
        return [
            'pesan' => $this->data['pesan'] ?? 'Update pesanan',
            // Menggunakan ?? (null coalescing operator)
            // Jika 'url' tidak ada, maka defaultnya adalah '#'
            'url'   => $this->data['url'] ?? '#',
        ];
    }
}
