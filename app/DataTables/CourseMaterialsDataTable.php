<?php

namespace App\DataTables;

use App\Course;
use App\Coursematerial;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;


class CourseMaterialsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query, Request $request)
    {

		if ( is_null($request->startDate) && is_null($request->endDate) ) {
			$query = Course::find( $request->courseId )->materials()->get();
		}
		else {
			$query = Course::find( $request->courseId )
				->materials()
				->where(
					function( $subquery ) use ($request) {
						$subquery->whereBetween('updated_at', [ $request->startDate ."  00:00:00", $request->endDate ." 23:59:59"])
							->orWhereBetween('created_at', [ $request->startDate ."  00:00:00", $request->endDate ." 23:59:59"]);
				})
				
				->get();
		}

        return Datatables::of($query)
			->addColumn('action', function($data) use ($request) {

				return "<div class='icheck-primary'>
							<input class='js-course-material-checkbox' data-material-id='$data->id' type='checkbox' id='$data->slug' autocomplete='off'>
							<label for='$data->slug'></label>
						</div>
						<a class='custom-primary add-material' href='#' data-material-id='$data->id' data-priority='".$data->pivot->priority."' data-toggle='modal' data-target='#add-additions-modal'>
							<i class='mdi mdi-plus-circle-outline mr-1'></i>
						</a>";
			})
			->editColumn('title', function($data) {

				if ($data->type != "Section") {

					return "<a href='/dashboard/material/$data->slug' class='h5 custom-link-primary'>$data->title</a>
							<p class='mb-1'>$data->slug</p>
							<a href='/dashboard/material/$data->slug' class='custom-link-primary'>Edit</a>
							<span class='mx-2'>|</span>
							<a href='#' class='custom-link-primary'>View</a>";

				}
				else {
					return "<h4>$data->title</h4>";
				}



			})
			->editColumn('status', function($data) use ($request) {

				$status = $data->pivot->status == 0 ? "" : "checked";

				return "<input class='js-toggle' data-course-id='$request->courseId'
					type='checkbox' id='". $data->slug ."-toggle-checkbox' 
					data-material-id='$data->id' $status data-switch='bool' autocomplete='off'/>
					<label for='". $data->slug ."-toggle-checkbox' class='mb-0' data-on-label='On' data-off-label='Off'></label>";

			})
			->editColumn('priority', function($data) {

				return "<div class='form-group'>
							<input type='text' class='form-control text-center js-sort-input' 
								data-material-id='$data->id' 
								data-current-priority=".$data->pivot->priority." 
								value=".$data->pivot->priority." autocomplete='off'>
						</div>";
			})
			->editColumn('type', function($data) {
				return "<p class='mb-1'>$data->type</p>";
			})
			->addColumn("btns", function($data) {

				return "<i class='js-remove-material h3 pt-1 mx-2 mdi mdi-delete-circle-outline custom-danger cursor-pointer'
					data-material-id='$data->id'></i>";
			})
			->rawColumns(
				[
					'action', 'title', 'status', 'priority',
					'type', 'updated_at', 'created_at', 'btns'
				]
			)
			->setRowClass(function ($data) {

				if ( $data->type == "Section" ) {
					
					return 'bg-light-gray';

				}
				else {
					return "row-hover";
				}

			})
			->setRowAttr(
				[ 'data-material-id' => function($data) {

						return  $data->id;

					},
					'data-material-slug' => function($data) {

						return $data->slug;
					}
				]);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \Course $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        // return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('coursematerials-table')
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
            Column::make('name'),
            Column::make('status'),
            Column::make('priority'),
            Column::make('type'),
            Column::make('updated_at'),
            Column::make('created_at'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'CourseMaterials_' . date('YmdHis');
    }
}
