<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class NewCommentNotification extends Notification {

    use Queueable;

    private $comment;
    private $course;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($comment, $course)
    {
        //
        $this->comment = $comment;
        $this->course = $course;

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
        $url = url('/home/course/' . $this->course->slug);

//        dd($this->comment);
        return (new MailMessage)
            ->subject("Νέο μήνυμα στο μάθημα " . $this->course->title)
            ->greeting("Καλώς ήρθατε!")
            ->line("Ο μαθητής " . User::find($this->comment->user_id)->fullName . " έστειλε")
            ->line(new HtmlString("<h3>" . ($this->comment->body) . "</h3>"))
            ->line("Για να πάτε στο μάθημα πατήστε τον παρακάτω σύνδεσμο.")
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
