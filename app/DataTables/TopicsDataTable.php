<?php

namespace App\DataTables;

use App\Topic;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Carbon\Carbon;

class TopicsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', function($data) {
				
				return "<div class='icheck-primary d-inline'>
							<input class='js-topic-checkbox' data-topic-id='$data->id' data-topic-title='$data->title' type='checkbox' id='$data->slug' autocomplete='off'>
							<label for='$data->slug'></label>
						</div>";

			})
			->editColumn('title', function($data) {

				return "<span class='h5 custom-link-primary cursor-pointer js-title'>$data->title</span>
					<input type='text' class='js-edit form-control d-none' data-topic-id='$data->id' value='$data->title' placeholder='Εισάγετε Τίτλο...'>
					<p class='mb-1'>$data->slug</p>
					<a href='#' class='js-quick-edit custom-link-primary'>Quick Edit</a>";

			})
			->editColumn('updated_at', function($data) {

				return Carbon::parse( $data->updated_at)->format( "d / m / Y" );

			})
			->editColumn('created_at', function($data) {

				return Carbon::parse( $data->created_at)->format( "d / m / Y" );

			})
			->rawColumns(['action', 'title']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \Topic $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Topic $model)
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
                    ->setTableId('topicsdatatable-table')
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
        return 'Topic_' . date('YmdHis');
    }
}
