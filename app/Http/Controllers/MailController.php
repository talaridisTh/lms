<?php

namespace App\Http\Controllers;


use App\Mail as AppMail;
use App\Mail\Email;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\RequiredIf;

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

	// public function searchUsers(Request $request) {

	// 	$users = User::where(function($query) use ($request) {
	// 		$query->where("last_name", "LIKE", "%$request->search%")
	// 			->orWhere("first_name", "LIKE", "%$request->search%")
	// 			->orWhere("email", "LIKE", "%$request->search%")->get();
	// 	})->select("id", "first_name", "last_name")->paginate(10);

	// 	$result = [];
	// 	$result["results"] = [];

	// 	foreach($users as $user) {
	// 		array_push($result['results'], [
	// 			"id" => "$user->id",
	// 			"text" => "$user->last_name $user->first_name"
	// 		]);
	// 	}

	// 	$result["pagination"] = [
	// 		"more" => $users->currentPage() !== $users->total()
	// 	];

	// 	echo json_encode($result);

	// }

    public function composeEmail() {
		return view('admin.mail.composeEmail');
	}

	public function sendNewsletter(Request $request) {

		// dd($request->all());

		$request->validate([
			"subject" => "required",
			"content" => "required",
			"recipients" => "required_if:button,===,send"
		],
		[
			"recipients.required_if" => "Δεν ορίστηκαν παραλήπτες."
		]);

		$users = $this->findRecipients($request);

		$recipients = [
			"ids" => [],
			"emails" => []
		];

		if ($request->button === "send") {
			foreach($users as $user) {
				array_push($recipients["ids"], $user->id);
				// Mail::to($user->email)
				// 	->send(new Email($request->subject, $request->content));
			}
		}
		else {
			if ( !is_null($users) ) {
				foreach($users as $user) {
					array_push($recipients["ids"], $user->id);
				}
			}
		}
			
		$this->storeEmail($request, is_null($users) ? null : $recipients, $request->button);

		$message = $request->button === "send" ? ["sent" => "sent"] : ["saved" => "saved"];

		return redirect("/dashboard/email")->with($message);
	}

	private function findRecipients(Request $request) {

		if ( isset($request->recipients) ) {
			$recipients = explode(",", $request->recipients);

			return User::find($recipients, ["id", "email"]);
		}

		return null;
	}

	private function storeEmail(Request $request, $recipients, $status) {
		$mail = new AppMail;
		$mail->user_id = Auth::user()->id;
		$mail->subject = $request->subject;
		$mail->content = $request->content;
		$mail->recipients = !is_null($recipients) ? json_encode($recipients) : null;
		$mail->sent_at = $status === "send" ? now() : null;
		$mail->save();
	}
}
