<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewAnnouncementNorification extends Notification {

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
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {

        $url = url('discussion');

//        dd($this->comment);
        return (new MailMessage)
            ->subject("Νέο ανακοίνωση ")
            ->greeting("Καλώς ήρθατε!")->
            line("Έχετε μια νέα ανακοίνωση.")
            ->line("Για να πάτε στην ανακοίνωση πατήστε τον παρακάτω σύνδεσμο.")
            ->action('Πήγαινε', $url)
            ->salutation("Ευχαριστούμε.");
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }

}
