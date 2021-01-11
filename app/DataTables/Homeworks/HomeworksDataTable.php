<?php

namespace App\DataTables\Homeworks;

use App\Models\Homework;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Str;

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
		if (!is_null($request->startDate) && !is_null($request->endDate)) {

            $query->where(function ($subquery) use ($request) {
				$subquery->whereBetween('updated_at', [$request->startDate . "  00:00:00", $request->endDate . " 23:59:59"])
					->orWhereBetween('created_at', [ $request->startDate ."  00:00:00", $request->endDate ." 23:59:59"]);
			});
		}
		
        return datatables()
            ->eloquent($query)
			->addColumn('action', function($homework) {

				$random = Str::random(10);

				return "<div class='icheck-primary d-inline'>
						<input type='checkbox' id='$random' autocomplete='off'>
						<label for='$random'></label>
					</div>";
			})
			->addColumn("student", function($homework) {
				
				return "<p class='mb-0'>".$homework->student->fullname."</p>
					<p class='mb-0'>".$homework->subject."</p>";
			})
			->addColumn("course", function($homework) {

				return $homework->course->title;
			})
			->rawColumns(["action", "student"]);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \Homework $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Homework $homework)
    {
        return $homework->with("student", "course");
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('homeworks/homeworksdatatable-table')
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
        return 'Homeworks/Homeworks_' . date('YmdHis');
    }
}
