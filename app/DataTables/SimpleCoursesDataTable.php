<?php

namespace App\DataTables;

use App\Course;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SimpleCoursesDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
		$query = Course::where("status", 1)->with("topics")->get();

        return datatables()::of($query)
			->addColumn('action', function($data) {

				return "<i class='js-add-course-banner p-2 font-20 mdi mdi-plus-circle-outline cursor-pointer'
					data-model='App\Course' data-model-id='$data->id' data-model-cover='$data->cover'
					data-model-title='$data->title' data-model-subtitle='$data->subtitle'></i>";

			})
			->editColumn('topics', function ($data) {

                $topics = [];
                foreach ($data->topics as $topic)
                {
                    array_push($topics, $topic['title']);
                }

                return implode(", ", $topics);
            })
			->rawColumns(["action"]);
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
                    ->setTableId('simplecoursesdatatable-table')
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
        return 'SimpleCourses_' . date('YmdHis');
    }
}
