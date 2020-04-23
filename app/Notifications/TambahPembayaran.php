<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Carbon\Carbon;

class TambahPembayaran extends Notification
{
    use Queueable;
    public $tagihan, $siswa;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($tagihan, $siswa)
    {
        $this->tagihan = $tagihan;
        $this->siswa = $siswa;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }


    public function toDatabase($notifiable)
    {
        return [
            'nama_tagihan'=>$this->tagihan,
            'siswa'=>$this->siswa,
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [

        ];
    }
}
