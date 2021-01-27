<?php

namespace App\DataTables\Materials;

use App\Models\Course;
use App\Models\Material;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Carbon;

class MaterialCoursesDataTable extends DataTable {

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query, Request $request)
    {
		if ( ! is_null($request->startDate) && ! is_null($request->endDate) ) {

			$query->where(function ($subquery) use ($request) {
				$subquery->whereBetween('courses.publish_at', [$request->startDate . "  00:00:00", $request->endDate . " 23:59:59"]);
			});
		}

		$query->with([
			"topics" => function($subquery) {
				$subquery->select("topics.id", "topics.title");
			}
		]);
		$query->select("courses.*");

        return datatables()->eloquent($query)
            ->addColumn('checkbox', function ($data) {
                return "<div class='icheck-primary d-inline'>
							<input class='js-course-inside-material'  id='$data->title' type='checkbox'  autocomplete='off'>
							<label for='$data->title'></label>
						</div>";
            })
            
            ->editColumn('title', function ($data) {

                return "<a href='/dashboard/courses/$data->slug/edit' class='h5 custom-link-primary'>$data->title</a>
						<p class='mb-1'>$data->slug</p>
						<a href='/dashboard/courses/$data->slug/edit' class='custom-link-primary'>Edit</a>
						<span class='mx-2'>|</span>
						<a href='/home/course/$data->slug' class='custom-link-primary'>View</a>
						<span class='mx-2'>|</span>
						<a href='javascript: void(0);' class='js-remove-btn custom-link-primary' data-course-id='$data->id'>Remove</a>";
			})
			->editColumn('toggle', function ($data) {

                $status = $data->status == 0 ? "" : "checked";

                return "<input class='js-toggle' data-course-id='$data->id' type='checkbox' id='$data->slug-toggle-checkbox' $status data-switch='success' autocomplete='off'/>
					<label for='$data->slug-toggle-checkbox' class='mb-0' data-on-label='On' data-off-label='Off'></label>";
			})
			->addColumn('topics', function ($data) {

                return $data->topics->map(function ($topics) {
                    return $topics->title;
                })->implode(", ");

			})
			->editColumn('publish', function ($data) {

				if ( $data->status == 1 ) {
					if ( time() > strtotime($data->publish_at) && !is_null($data->publish_at) ) {
						$status = ["icon" => "badge-outline-success", "text" => "Published"];
					}
					else {
						$status = ["icon" => "badge-outline-primary", "text" => "Scheduled"];
					}
				}
				else {
					$status = ["icon" => "badge-outline-danger", "text" => "Draft"];
				}

				$date = !is_null($data->publish_at) ? Carbon::parse($data->publish_at)->format("d-m-Y") : "";
				$time = !is_null($data->publish_at) ? Carbon::parse($data->publish_at)->format("H:i") : "";

				return "<div class='js-publish-cover cursor-pointer'>
						<span class='js-badge badge ".$status['icon']." badge-pill'>".$status['text']."</span>
						<p class='js-date mb-0 mt-1'>$date</p><p class='js-time mb-0'>$time</p>
					</div>
				<input class='js-publish-picker form-control d-none'
					type='text' value='$date $time' data-course-id='$data->id'>";
			})
            ->addColumn('active', function ($data) {

                return $data->status;
			})
			->filterColumn("topics.title", function($query, $keyword) {
				
				$query->whereHas("topics", function($sub) use ($keyword) {
					$sub->where("title", $keyword);
				});

			})
            ->rawColumns(["checkbox", "title", "toggle","topics", "publish"])
            ->setRowAttr([
                'data-course-id' => function ($data) {
                    return $data->id;
                }
            ]);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\CourseInsideMaterial $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Material $material, Request $request)
    {
		$courses = Material::find($request->materialId)
			->courses();

		if ( auth()->user()->hasRole("instructor") ) {
			$courseIds = auth()->user()->courses()->pluck("courses.id")->toArray();
			$courses->whereIn("courses.id", $courseIds);
		}

		return $courses;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('courseinsidematerials-table')
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
        return 'CourseInsideMaterials_' . date('YmdHis');
    }

}
