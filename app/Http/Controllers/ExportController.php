<?php

namespace App\Http\Controllers;

use App\Exports\UsersExportView;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    //
    public function actions($ids)
    {




        return Excel::download(new UsersExportView($ids),"users.xlsx" );




    }
//
//    public function usersAll ()
//    {
//
//        return Excel::download(new UsersExportView(),"users.xlsx" );
//
//    }
}
