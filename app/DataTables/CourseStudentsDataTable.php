<?php

namespace App\DataTables;

use App\Course;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CourseStudentsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable( $query, Request $request )
    {

		$query = Course::find( $request->courseId )
			->users()
			->whereIn( 'users.id', 
				function($subquery) {

					$subquery->select('model_id')
						->from('model_has_roles')
						->where('role_id', 4)
						->get();

				}
			)
			->get();

        return datatables()::of($query)
            ->addColumn('action', function($data) {

				$pattern = "/[-!$%^&*(@)_+|~=`{}\[\]:\";'<>?,.\/]/m";
				$slug = preg_replace($pattern, "", $data->email);

				return "<div class='icheck-primary d-inline'>
							<input class='js-remainings-checkbox' data-user-id='$data->id' type='checkbox' id='$slug' autocomplete='off'>
							<label for='$slug'></label>
						</div>";

			})
			->addColumn('btn', function($data) {

				return "<i class='js-remove-student h3 pt-1 uil uil-trash-alt cursor-pointer' data-user-id='$data->id'></i>";
				
			})
			->rawColumns(['action', 'btn']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \Course $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Course $model)
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
                    ->setTableId('coursestudentsdatatable-table')
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
        return 'CourseStudents_' . date('YmdHis');
    }
}
