<?php

namespace App\DataTables;

use App\Course;
use App\CoursesInsideUser;
use App\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CoursesInsideUsersDataTable extends DataTable
{

    public function dataTable($query, Request $request)
    {

        $user = User::findOrFail($request->user_id);
        $query = $user->courses()->get();

        return DataTables::of($query);
//            ->addColumn('action', 'coursesinsideusers.action');
    }


    public function query(Course $model)
    {
        return $model->newQuery();
    }


    protected function filename()
    {
        return 'CoursesInsideUsers_' . date('YmdHis');
    }
}
