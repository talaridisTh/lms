<?php

namespace App\Http\Controllers;

use App\Mail\Email;
use App\Role;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
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

		if (isset($request->recipientsRoles)) {
			$users = User::role(["partner", "instructor"])->select("email")->get();

			foreach($users as $user) {
				Mail::to($user->email)
					->send(new Email($request->subject, $request->content));
			}
		}
		else {
			$users = User::find($request->recipients);

			foreach($users as $user) {
				Mail::to($user->email)
					->send(new Email($request->subject, $request->content));
			}
		}
	}
}
