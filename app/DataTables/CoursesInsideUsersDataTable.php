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

        return DataTables::of($query)
       ->addColumn('action', function($data) {

				return "<div class='icheck-primary d-inline'>
							<input class='js-user-checkbox-sub' data-course-id='$data->id' data-course-name='$data->name' type='checkbox' id='$data->slug' autocomplete='off'>
							<label for='$data->slug'></label>
						</div>";

			})
//			->editColumn('active', function($data) {
//
//				$active = $data->active == 0 ? "" : "checked";
//
//				return "<input class='js-toggle' data-course-id='$data->id' type='checkbox' id='$data->slug-toggle-checkbox' $active data-switch='bool' autocomplete='off'/>
//					<label for='$data->slug-toggle-checkbox' data-on-label='On' data-off-label='Off'></label>";
//
//			})
			->rawColumns(['action', 'active'])
			->setRowClass("test")
			->setRowAttr([ 'data-course-id' => function($data) {

				return  $data->id;

			}]);
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
