<?php

namespace App\Mail;

use App\Models\Attachment;
use Illuminate\Bus\Queueable;
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
    public $ids;

    public function __construct($mailInfo, $homework, $ids)
    {
        $this->mailInfo = $mailInfo;
        $this->homework = $homework;
        $this->ids = $ids;
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
            ->view('index.mail.task');
        if (isset($this->mailInfo->attachment) && !isset($this->ids)) {
            foreach (json_decode($this->mailInfo->attachment) as $filePath) {
                $amount = json_decode($this->mailInfo->receiver->seen)->seen_task + 1;
                $this->mailInfo->receiver->update(['seen->seen_task' => $amount]);
                Attachment::findOrFail($filePath->id)->update(
                    [
                        "attachmentable_type" => "App\Models\Homework",
                        "attachmentable_id" => $this->homework->id
                    ]
                );
                $email->attach(public_path($filePath->path));
            }
        } elseif (isset($this->ids)) {
            foreach ($this->ids as $filePath) {

                $amount = json_decode($this->mailInfo->receiver->seen)->seen_task + 1;
                $this->mailInfo->receiver->update(['seen->seen_task' => $amount]);
                Attachment::findOrFail($filePath["id"])->update(
                    [
                        "attachmentable_type" => "App\Models\Homework",
                        "attachmentable_id" => $this->homework->id
                    ]
                );
                $email->attach(public_path($filePath["url"]));
            }
        }
//            ->with($this->mailInfo);
//            ->attach(public_path('storage/files/2020.12/zoom216.pdf'));
    }

}
