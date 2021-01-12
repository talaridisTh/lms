<?php

namespace App\DataTables\Users;

use App\Models\Homework;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class HomeworksDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query, Request $request)
    {
		$query->where("student_id", $request->userId);

        return datatables()
			->eloquent($query)
			->editColumn("subject", function($homework) {

				return "<a class='h5 custom-link-primary' href='javascript: void(0)'
					data-toggle='modal' data-target='#view-homework-modal' data-id='$homework->id'>$homework->subject</a>";
			})
			->editColumn("course", function($homework) {

				return $homework->course->title;
			})
			->rawColumns(["subject"]);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \Homework $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Homework $model)
    {
        return $model->newQuery()->with("student", "course", "attachments");
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('users/homeworks-table')
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
        return 'Users/Homeworks_' . date('YmdHis');
    }
}
