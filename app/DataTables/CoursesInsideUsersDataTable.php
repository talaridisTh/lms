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
       ->addColumn('action', function($data) use($user) {

				return "<div class='icheck-primary d-inline'>
							<input class='js-user-checkbox-sub' data-course-id='$data->id' data-user-id='$user->id' data-course-title='$data->title' type='checkbox' id='$data->slug' autocomplete='off'>
							<label for='$data->slug'></label>
						</div>";

			})
            ->editColumn('title', function($data) {

                return "<a href='/dashboard/course/$data->slug' class='h5 custom-link-primary'>$data->title</a>
						<p class='mb-1'>$data->slug</p>
						<a href='/dashboard/course/$data->slug' class='custom-link-primary'>Edit</a>
						<span class='mx-2'>|</span>
						<a href='#' class='custom-link-primary'>View</a>";

            })
			->editColumn('updated_at', function($data) {

				return $data->updated_at->diffForHumans();


			})
            ->editColumn('created_at', function($data) {

                return $data->created_at->diffForHumans();


            })
			->rawColumns(['action', 'status',"title"])
			->setRowAttr([ 'data-course-id' => function($data) {

				return  $data->slug;

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
