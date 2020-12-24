<?php

namespace App\Mail;

use App\Models\Attachment;
use App\Models\Media;
use App\Models\Mediable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailTask extends Mailable {

    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $homework;

    public function __construct($mailInfo,$homework)
    {
        $this->mailInfo = $mailInfo;
        $this->homework = $homework;
//        dd( json_decode($this->mailInfo->attachment));
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = $this->from($this->mailInfo->sender->email)
            ->to($this->mailInfo->receiver->email)
            ->subject($this->mailInfo->subject)
            ->view('welcome');
        if (isset($this->mailInfo->attachment))
        {
            foreach (json_decode($this->mailInfo->attachment) as $filePath)
            {
                Attachment::findOrFail($filePath->id)->update(
                    [
                        "attachmentable_type" => "App\Models\Homework",
                        "attachmentable_id" => $this->homework->id
                    ]
                );

                $email->attach(public_path($filePath->path));
            }
        }
//            ->with($this->mailInfo);
//            ->attach(public_path('storage/files/2020.12/zoom216.pdf'));
    }

}
