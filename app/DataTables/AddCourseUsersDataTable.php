<?php

namespace App\DataTables;

use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class
AddCourseUsersDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query, Request $request)
    {

		$query = DB::table('users')
			->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
			->whereIn('model_has_roles.role_id', [ 2, 4 ])
			->whereNotIn('users.id', function($subquery) use ($request) {

				$subquery->select('user_id')
					->from('course_user')
					->where('course_id', $request->courseId)
					->get();

			})
			->select(
				'users.id as userId',
				'first_name',
				'last_name',
				'email',
				'phone',
				'slug',
				'model_has_roles.role_id')
			->get();





        return datatables()::of($query)
            ->addColumn('action', function($data) {

				$pattern = "/[-!$%^&*(@)_+|~=`{}\[\]:\";'<>?,.\/]/m";
				$slug = preg_replace($pattern, "", $data->email);

				return "<div class='icheck-primary d-inline'>
							<input class='js-new-user-checkbox' data-user-id='$data->userId' type='checkbox' id='$slug' autocomplete='off'>
							<label for='$slug'></label>
						</div>";

			})
            ->addColumn('addBtn', function($data) {

				return "<button type='button' class='js-add-user-btn btn btn-primary' data-user-id='$data->userId'>Προσθήκη</button>";

			})
			->addColumn('role', function($data) {

				return $data->role_id == 2 ? "Εισηγητής" : "Μαθητής";

			})
			->rawColumns(['action', 'addBtn'])
			->setRowAttr([ 'data-user-id' => function($data) {

				return  $data->userId;

			},
			"data-user-slug" => function($data) {

				return $data->slug;

			}]);
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
