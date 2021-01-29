<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmailRequest;
use App\Models\Mail as AppMail;
use App\Mail\Email;
use App\Models\User;
use App\Traits\AttachmentUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
	use AttachmentUploader;

	public function index() {

		return view("admin.mail.mailMain");
	}

	public function show(AppMail $mail) {

		$recipients = json_decode($mail->recipients);

		if ($recipients) {
			$recipients = User::find($recipients->ids);
		}

		$mail->load("attachments");

		$data = [
			"mail" => $mail,
			"recipients" => $recipients,
			"body" => new Email($mail->subject, $mail->content)
		];

		return view("admin.mail.editMail")->with($data);
	}

    public function composeEmail(AppMail $mail = null) {

		return view('admin.mail.composeEmail', compact("mail"));
	}

	public function sendNewsletter(EmailRequest $request) {

		$files = [];
		
		if ( isset($request->file) ) {

			foreach ($request->file as $file) {
	
				$attachment = $this->storeAttachment($file);
				array_push($files, $attachment);
			}
		}

		$users = $this->findRecipients($request);

		$recipients = [
			"ids" => []
		];

		foreach($users as $user) {
			array_push($recipients["ids"], $user->id);

			Mail::to($user->email)
			 	->send(new Email($request->subject, $request->content, $files));
		}

		$mail = $this->storeEmail($request, $recipients);
		$mail->attachments()->saveMany($files);

		if($request->ajax()){
			return response("Successful", 200);
		}
		return redirect("/dashboard/email");
	}

	public function delete(AppMail $mail) {

		if ( auth()->user()->hasRole(["super-admin", "admin"]) ) {
			$mail->delete();
		}
		else {
			$mail->update([
				"instructor_deleted_at" => now()
			]);
		}

		return view("admin.mail.mailMain");
	}

	private function findRecipients(Request $request) {

		if ( isset($request->recipients) ) {
			$recipients = explode(",", $request->recipients);

			return User::find($recipients, ["id", "email"]);
		}

		return null;
	}

	private function storeEmail(Request $request, $recipients) {

		$mail = new AppMail;
		$mail->user_id = Auth::user()->id;
		$mail->subject = $request->subject;
		$mail->content = $request->content;
		$mail->recipients = json_encode($recipients);
		$mail->sent_at = now();
		$mail->save();

		return $mail;
	}
}
