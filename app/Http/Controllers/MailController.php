<?php

namespace App\Http\Controllers;

use App\DataTables\MailsDataTable;
use App\Mail as AppMail;
use App\Mail\Email;
use App\Role;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
	public function index() {

		return view("admin.mail.mailMain");
	}

	public function mailsTable(MailsDataTable $dataTable) {

		return $dataTable->render('mails.table');

	}

	public function searchUsers(Request $request) {

		$users = User::where(function($query) use ($request) {
			$query->where("last_name", "LIKE", "%$request->search%")
				->orWhere("first_name", "LIKE", "%$request->search%")
				->orWhere("email", "LIKE", "%$request->search%")->get();
		})->select("id", "first_name", "last_name")->paginate(10);

		$result = [];
		$result["results"] = [];

		foreach($users as $user) {
			array_push($result['results'], [
				"id" => "$user->id",
				"text" => "$user->last_name $user->first_name"
			]);
		}

		$result["pagination"] = [
			"more" => $users->currentPage() !== $users->total()
		];

		echo json_encode($result);

	}

    public function composeEmail() {
		return view('admin.mail.composeEmail');
	}

	public function sendNewsletter(Request $request) {

		$recipients = [
			"ids" => [],
			"emails" => []
		];

		if (isset($request->recipientsRoles)) {
			$users = User::role($request->recipientsRoles)->select("id", "email")->get();

			foreach($users as $user) {
				array_push($recipients["ids"], $user->id);
				// Mail::to($user->email)
				// 	->send(new Email($request->subject, $request->content));
			}
		}
		else {
			$users = User::find($request->recipients, ["id", "email"]);

			foreach($users as $user) {
				array_push($recipients["ids"], $user->id);
				// Mail::to($user->email)
				// 	->send(new Email($request->subject, $request->content));
			}
		}

		$mail = new AppMail;
		$mail->user_id = Auth::user()->id;
		$mail->subject = $request->subject;
		$mail->content = $request->content;
		$mail->recipients = json_encode($recipients);
		$mail->status = 1;
		$mail->sent_at = now();
		$mail->save();
	}
}
