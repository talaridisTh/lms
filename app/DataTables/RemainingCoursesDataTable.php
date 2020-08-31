<?php

namespace App\DataTables;

use App\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class RemainingCoursesDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query, Request $request)
    {
		$query = DB::table('courses')
			->whereStatus( 1 )
			->where("deleted_at", null)
			->whereNotIn( 'id', 

				function($subquery) use ( $request ){
					$subquery->select('course_id')
						->from('bundle_course')
						->where('bundle_id', $request->bundleId)
						->get();
				}

			);

        return datatables()::of($query)
			->addColumn('action', function($data) {

				return "<div class='icheck-primary d-inline ml-2'>
							<input class='js-remainings-checkbox' data-course-id='$data->id' type='checkbox' id='$data->slug' autocomplete='off'>
							<label for='$data->slug'></label>
						</div>";

			})
			->addColumn('addBtn', function($data) {

				return "<button type='button' class='btn btn-primary js-add-course-btn' data-course-id='$data->id'>Προσθήκη</button>";

			})
			->setRowClass('last-column-p-10')
			->rawColumns(['action', 'addBtn']);
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
                    ->setTableId('remainingcoursesdatatable-table')
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
        return 'RemainingCourses_' . date('YmdHis');
    }
}
