<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Crypt;

class SentPasswordNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
		$url = url("/login");
		$password = Crypt::decryptString($notifiable->password_encrypt);

		return (new MailMessage)
			->subject("Ανάκτηση λογαριασμού.")
			->greeting("Στοιχεία σύνδεσης")
			->line("Εmail: ". $notifiable->email)
			->line("Κωδικός: $password")
			->line("Για να συνδεθείτε ακολουθείστε τον παρακάτω σύνδεσμο.")
        	->action('Σύνδεση', $url)
        	->salutation("Ευχαριστούμε.");
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
            //
        ];
    }
}
