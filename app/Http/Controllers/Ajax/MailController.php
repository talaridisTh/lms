<?php

namespace App\Http\Controllers\Ajax;

use App\DataTables\Mail\RecipientsDataTable;
use App\DataTables\Mail\UsersDataTable;
use App\DataTables\Mail\MailsDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mail as AppMail;

class MailController extends Controller
{
    public function mailsDataTable(MailsDataTable $dataTable) {

		return $dataTable->render('admin.mail.mailMain');

	}

	public function selectUsersDatatable(UsersDataTable $dataTable) {
		return $dataTable->render('admin.mail.composeEmail');
	}

	public function recipeintsDatatable(RecipientsDataTable $dataTable) {
		return $dataTable->render('admin.mail.composeEmail');
	}

	public function delete(Request $request) {

		foreach ($request->mailIds as $id) {
			AppMail::find($id)->delete();
		}
	}
}
