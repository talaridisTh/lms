<?php

namespace App\DataTables\Courses;

use App\Models\Course;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Carbon;

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
			$query = Course::find( $request->courseId )->materials;
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
							<input class='js-course-material-checkbox' data-material-id='$data->id'
								data-material-type='$data->type' type='checkbox' id='$data->slug' autocomplete='off'>
							<label for='$data->slug'></label>
						</div>
						<a class='custom-primary add-material' href='#' data-material-id='$data->id' data-priority='".$data->pivot->priority."' data-toggle='modal' data-target='#add-additions-modal'>
							<i class='mdi mdi-plus-circle-outline mr-1'></i>
						</a>";
			})
			->editColumn('title', function($data) {

				if ( $data->status == 1 ) {
					$badge = "";
				}
				else {
					$badge = "<span class='badge badge-outline-danger badge-pill ml-3'>Inactive</span>";
				}

				if ($data->type === "PDF") {
					return "<a href='/dashboard/pdf/$data->slug/edit' class='h5 custom-link-primary'>$data->title </a>$badge
							<p class='mb-1'>$data->slug</p>
							<a href='/dashboard/pdf/$data->slug/edit' class='custom-link-primary'>Edit</a>
							<span class='mx-2'>|</span>
							<a href='#' class='custom-link-primary'>View</a>
							<span class='mx-2'>|</span>
							<a href='#' class='js-remove-material custom-link-primary'
								data-material-id='$data->id' data-material-type='$data->type'
							>Remove</a>";
				}
				else if ($data->type != "Section") {

					return "<a href='/dashboard/materials/$data->slug/edit' class='h5 custom-link-primary mb-0'>$data->title </a>$badge
							<p class='my-1'>$data->slug</p>
							<a href='/dashboard/materials/$data->slug/edit' class='custom-link-primary'>Edit</a>
							<span class='mx-2'>|</span>
							<a href='#' class='custom-link-primary'>View</a>
							<span class='mx-2'>|</span>
							<a href='#' class='js-remove-material custom-link-primary'
								data-material-id='$data->id' data-material-type='$data->type'
							>Remove</a>";

				}
				else {
					return "<h5 class='js-section cursor-pointer mt-0'
						data-slug='$data->slug'>
							$data->title
						</h5>
						<p class='mb-1'>Σύνολο υλικού: ".$data->chapters()->count()."</p>
						<a href='#' class='js-remove-material custom-link-primary'
							data-material-id='$data->id' data-material-type='$data->type'
							>Delete</a>";
				}
			})
			->editColumn("highlight", function($data) {

				$highlight = $data->pivot->highlight === 0 ? "" : "checked";
				$disabled = $data->type === "Section" ? "disabled" : "";

				return "<div class='icheck-success'>
							<input class='js-course-material-highlight'
								data-material-id='$data->id' type='checkbox'
								id='$data->slug-highlight' $highlight 
								$disabled autocomplete='off'>
							<label for='$data->slug-highlight'></label>
						</div>";
			})
			->editColumn('status', function($data) use ($request) {

				$status = $data->pivot->status == 0 ? "" : "checked";

				return "<input class='js-toggle' data-course-id='$request->courseId'
					type='checkbox' id='". $data->slug ."-toggle-checkbox' data-type='$data->type'
					data-material-id='$data->id' $status data-switch='success' autocomplete='off'/>
					<label for='". $data->slug ."-toggle-checkbox' class='mb-0 mt-1' data-on-label='On' data-off-label='Off'></label>";

			})
			->editColumn('priority', function($data) {

				return "<div class='form-group mb-0'>
							<input type='text' class='form-control text-center js-sort-input'
								data-material-id='$data->id'
								data-current-priority=".$data->pivot->priority."
								value=".$data->pivot->priority." autocomplete='off'>
						</div>";
			})
			->editColumn('type', function($data) {
				return "<p class='mb-1'>$data->type</p>";
			})
			->editColumn('publish', function ($data) {

				if ( $data->pivot->status == 1 ) {
					if ( time() > strtotime($data->pivot->publish_at) && !is_null($data->pivot->publish_at) ) {
						$status = ["icon" => "badge-outline-success", "text" => "Published"];
					}
					else {
						$status = ["icon" => "badge-outline-primary", "text" => "Scheduled"];
					}
				}
				else {
					$status = ["icon" => "badge-outline-danger", "text" => "Draft"];
				}

				if ( !is_null($data->pivot->publish_at) ) {
					$date = Carbon::parse($data->pivot->publish_at)->format("d-m-Y");
					$time = Carbon::parse($data->pivot->publish_at)->format("H:i");
					$datetime = Carbon::parse($data->pivot->publish_at)->format("d-m-Y H:i");
				}
				else {
					$date = "";
					$time = "";
					$datetime = "";
				}

				return "
						<div class='js-publish-cover cursor-pointer' data-material-id='$data->id'>
							<span class='js-badge badge ".$status['icon']." badge-pill'>".$status['text']."</span>
							<p class='js-date mb-0 mt-1'>$date</p><p class='js-time mb-0'>$time</p>
						</div>
						<input class='js-publish-picker form-control d-none' type='text' value='$datetime'>";
			})
			->rawColumns(
				[
					'action', 'title', 'status', 'priority', 'highlight',
					'type', 'publish'
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
					"data-priority" => function($data) {
						return $data->pivot->priority;
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
