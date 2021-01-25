<?php

namespace App\Http\Controllers;


use App\Models\Mail as AppMail;
use App\Mail\Email;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
	public function index() {

		return view("admin.mail.mailMain");
	}

	public function show(AppMail $mail) {

		$recipients = json_decode($mail->recipients);

		if ($recipients) {
			$recipients = User::find($recipients->ids);
		}

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

	public function sendNewsletter(Request $request) {

		$request->validate([
			"subject" => "required",
			"content" => "required",
			"recipients" => "required"
		],
		[
			"recipients.required" => "Δεν ορίστηκαν παραλήπτες."
		]);

		$users = $this->findRecipients($request);

		$recipients = [
			"ids" => []
		];

		foreach($users as $user) {
			array_push($recipients["ids"], $user->id);
			//  Mail::to($user->email)
			//  	->send(new Email($request->subject, $request->content));
		}

		$this->storeEmail($request, $recipients, $request->button);

		$message = ["sent" => "sent"];

		return redirect("/dashboard/email")->with($message);
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

	private function storeEmail(Request $request, $recipients, $status) {

		if ( isset($request->id) ) {
			$mail = AppMail::find($request->id);
		}
		else {
			$mail = new AppMail;
		}

		$mail->user_id = Auth::user()->id;
		$mail->subject = $request->subject;
		$mail->content = $request->content;
		$mail->recipients = json_encode($recipients);
		$mail->sent_at = now();
		$mail->save();
	}
}
