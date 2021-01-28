<?php

namespace App\Mail;

use App\Models\Attachment;
use App\Models\Option;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Email extends Mailable
{
    use Queueable, SerializesModels;

	public $logo;
	public $contactInfo;
	public $socialLinks;
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
		$this->contactInfo = json_decode(Option::where("name", "Contact Info")->first()->value);
		$this->socialLinks = json_decode(Option::where("name", "Social")->first()->value);
		$this->logo = Option::where("name", "Logo")->first()->value;
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
		$mail = $this->view('admin.mail.templates.default');

		foreach ($this->mailAttachments as $attachment) {
			
			$mail->attach( public_path($attachment->rel_path), [
				"as" => $attachment->original_name,
				"mime" => $attachment->file_info
			]);
		}

        return $mail;
    }
}
