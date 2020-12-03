<?php

namespace App\DataTables\Topics;

use App\Topic;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Http\Request;

class TopicsDataTable extends DataTable {

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query, Request $request)
    {

        if (!is_null($request->startDate) && !is_null($request->endDate))
        {
            $query = Topic::query()
                ->where(function ($subquery) use ($request) {
                    $subquery->whereBetween('updated_at', [$request->startDate . "  00:00:00", $request->endDate . " 23:59:59"])
                        ->orWhereBetween('created_at', [$request->startDate . "  00:00:00", $request->endDate . " 23:59:59"]);
                });
        }

        return datatables()::of($query)
            ->addColumn('action', function ($data) {

                return "<div class='icheck-primary d-inline'>
							<input class='js-topic-checkbox' data-topic-id='$data->id' data-topic-title='$data->title' type='checkbox' id='$data->slug' autocomplete='off'>
							<label for='$data->slug'></label>
						</div>";
			})
            ->editColumn('title', function ($data) {

				return "<h5 class='js-quick-edit custom-link-primary cursor-pointer js-title'>$data->title</h5>
					<div class='js-edit form-group d-none'>
						<label>Τίτλος</label>
						<div class='input-group'>
							<input type='text' class='form-control' data-topic-id='$data->id' value='$data->title' placeholder='Εισάγετε Τίτλο...'>
							<div class='invalid-feedback'>
								Το πεδίο είναι υποχρεωτικό.
							</div>
							<div class='input-group-append'>
								<button class='btn btn-primary js-save' type='button'>Save</button>
							</div>
							<div class='input-group-append'>
								<button class='btn btn-light ml-2 js-cancel' type='button'>Cancel</button>
							</div>
						</div>
					</div>
					<p class='mb-1'>$data->slug</p>
					<a href='#' class='js-quick-edit custom-link-primary'>Quick Edit</a>
					<span class='mx-2'>|</span>
					<a href='#' class='js-edit-gradient custom-link-primary' data-target='#color-modal'
						data-toggle='modal' data-topic-id='$data->id' data-gradient='$data->color'
						data-topic-title='$data->title'>
						Edit Gradient
					</a>";
			})
			->addColumn("gradient", function($data) {

				$preview = !is_null($data->color) ? "style='background:$data->color'" : "";

				return "<div class='gradient-cnt mt-2 cursor-pointer' data-target='#color-modal'
							data-toggle='modal' data-topic-id='$data->id' data-topic-title='$data->title'
						 data-gradient='$data->color' $preview></div>";
			})
            ->rawColumns(['action', 'title', "gradient"]);
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
