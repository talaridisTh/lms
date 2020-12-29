<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Option;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;

class EmailVerifyNotification extends Notification
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
        $this->title = Option::where("name", "Title")->first()->value
			?? "Darkpony Digital";

		$this->description = Option::where("name", "Description")->first()->value
			?? "Demo Project";

        $this->logo = Option::where("name", "Logo")->first()->value
			?? "/images/darkpony-logo.png";

		$this->copyright = Option::where("name", "Copyright")->first()->value
			?? "DARKPONY. ALL RIGHTS RESERVED";
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

			$title = $this->title;
			$description = $this->description;
			$logo = $this->logo;
			$copyright = $this->copyright;
			$url = $this->verificationUrl($notifiable);


        return (new MailMessage)
			->view("admin.mail.templates.newUserNotification", compact([
				"url", "title", "description", "logo", "copyright"
			]));
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
