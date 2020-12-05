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

	public $logo;
	public $contactInfo;
	public $socialLinks;
	public $subject;
	public $content;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject, $content)
    {
		$this->contactInfo = json_decode(Option::where("name", "Contact Info")->first()->value);
		$this->socialLinks = json_decode(Option::where("name", "Social")->first()->value);
		$this->logo = Option::where("name", "Logo")->first()->value;
        $this->subject = $subject;
        $this->content = $content;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('admin.mail.templates.default');
    }
}
