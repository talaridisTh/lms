<?php

namespace App\DataTables\Courses;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query, Request $request)
    {
		$query = User::role(["instructor", "student"])->where("status", 1)
			->whereNotIn("users.id", function($subquery) use ($request) {

				$subquery->select('user_id')->from('course_user')
					->where('course_id', $request->courseId)->get();

			})->with("roles")->select("users.*");

        return datatables()::of($query)
            ->addColumn('action', function($data) {

				$pattern = "/[-!$%^&*(@)_+|~=`{}\[\]:\";'<>?,.\/]/m";
				$slug = preg_replace($pattern, "", $data->email);

				return "<div class='icheck-primary d-inline'>
							<input class='js-new-user-checkbox' data-user-id='$data->id' type='checkbox' id='$slug' autocomplete='off'>
							<label for='$slug'></label>
						</div>";

			})
			->editColumn("last_name", function($data) {
				$badge = "";

				if ( is_null($data->email_verified_at) ) {
					$badge .= "<span class='badge badge-outline-warning badge-pill ml-3'>Unverified</span>";
				}

				return "
					<span>$data->last_name $data->first_name</span>$badge
				";
			})
            ->addColumn('addBtn', function($data) {

				return "<button type='button' class='js-add-user-btn btn btn-primary' data-user-id='$data->id'>Προσθήκη</button>";

			})
			->addColumn('role', function($data) {

				// dump($data->getRoleNames());
				return $data->getRoleNames()[0] === "instructor" ? "Εισηγητής" : "Μαθητής";

			})
			->filterColumn("role", function($query, $keyword) {
				$query->whereHas("role", $keyword);
			})
			->rawColumns(['action', 'last_name', 'addBtn']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('addcoursestudentsdatatable-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->buttons(
                        Button::make('create'),
                        Button::make('export'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center'),
            Column::make('id'),
            Column::make('add your columns'),
            Column::make('created_at'),
            Column::make('updated_at'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'AddCourseStudents_' . date('YmdHis');
    }
}
