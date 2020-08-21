<?php

namespace App\Http\Controllers;

use App\Exports\UsersExportView;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    //


    public function usersAll ()
    {

        return Excel::download(new UsersExportView(),"users.xlsx" );

    }
}
