<?php

namespace App\Mail;

use App\Models\Option;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Email extends Mailable
{
    use Queueable, SerializesModels;

	private $logo;
	private $title;
	private $copyright;
	public $subject;
	public $content;
	public $mailAttachments;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject, $content, $mailAttachments = [])
    {
		$this->logo = Option::where("name", "Logo")->first()->value
			?? "/images/darkpony-logo.png";
		$this->title = Option::where("name", "Title")->first()->value
			?? "Darkpony Digital";
		$this->copyright = Option::where("name", "Copyright")->first()->value
			?? "Darkpony. All rights reserved.";
        $this->subject = $subject;
		$this->content = $content;
		$this->mailAttachments = $mailAttachments;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
		$mail = $this->markdown('admin.mail.templates.email')->with([
			"logo" => $this->logo,
			"title" => $this->title,
			"copyright" => $this->copyright
		]);

		foreach ($this->mailAttachments as $attachment) {
			
			$mail->attach( public_path($attachment->rel_path), [
				"as" => $attachment->original_name,
				"mime" => $attachment->file_info
			]);
		}

        return $mail;
    }
}
