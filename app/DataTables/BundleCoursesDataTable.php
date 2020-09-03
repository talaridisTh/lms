<?php

namespace App\DataTables;

use App\Bundle;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Carbon\Carbon;

class BundleCoursesDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query, Request $request)
    {
		$query = Bundle::find( $request->bundleId )
			->courses()
			->select(
				'courses.id', 
				'courses.title', 
				'courses.slug', 
				'courses.updated_at', 
				'courses.created_at'
			);

        return datatables()
            ->eloquent($query)
			->addColumn('action', function($data) {

				return "<div class='icheck-primary d-inline'>
							<input class='js-course-checkbox' data-course-id='$data->id' type='checkbox' id='$data->slug' autocomplete='off'>
							<label for='$data->slug'></label>
						</div>";

			})
			->editColumn('updated_at', function($data) {

				return Carbon::parse( $data->updated_at)->format( "d / m / Y" );

			})
			->editColumn('created_at', function($data) {

				return Carbon::parse( $data->created_at)->format( "d / m / Y" );

			})
			->rawColumns(['action'])
			->setRowAttr(['data-course-id' => function($data) {

				return $data->id;
				
			}]);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Bundle $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Bundle $model)
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
                    ->setTableId('bundlecoursesdatatable-table')
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
        return 'BundleCourses_' . date('YmdHis');
    }
}
