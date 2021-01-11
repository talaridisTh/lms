<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\URL;

class NewUserNotification extends Notification implements ShouldQueue
{
    use Queueable;

	public $title;
	public $description;
	public $logo;
	public $copyright;

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
		// $url = $this->verificationUrl($notifiable);
		$url = url("/login");
		$password = Crypt::decryptString($notifiable->password_encrypt);

		return (new MailMessage)
			->subject("Ενεργοποίηση λογαριασμού")
			->greeting("Καλώς ήρθατε!")
			->line("Για την είσοδο σας μπορείτε να χρησιμοποιήσεται το email σας: ". $notifiable->email)
			->line("Ο κωδικός σας είναι: $password")
			->line("Για να συνδεθείτε κάντε κλίκ στον παρακάτω σύνδεσμο.")
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
	
	public function verificationUrl($notifiable) {

		return URL::temporarySignedRoute(
            'email.verify',
            Carbon::now()->addHours(24),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
	}
}
