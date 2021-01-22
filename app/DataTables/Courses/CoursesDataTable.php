<?php

namespace App\DataTables\Courses;

use App\Models\Course;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CoursesDataTable extends DataTable {

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
				$subquery->whereBetween('publish_at', [$request->startDate . "  00:00:00", $request->endDate . " 23:59:59"])
					->orWhereBetween('created_at', [ $request->startDate ."  00:00:00", $request->endDate ." 23:59:59"]);
			})->with("topics");
		}
		else {

            $query->with("topics");
        }

        return datatables()::of($query)
            ->addColumn('action', function ($data) {

                return "<div class='icheck-primary d-inline'>
							<input class='js-course-checkbox' data-course-id='$data->id' data-course-title='$data->title' type='checkbox' id='$data->slug' autocomplete='off'>
							<label for='$data->slug'></label>
						</div>";
            })
            ->editColumn('title', function ($data) {

                return (
                "<a href='/dashboard/courses/$data->slug/edit' class='h5 custom-link-primary'>$data->title</a>
				<p class='mb-1'>$data->slug</p>
				<a href='/dashboard/courses/$data->slug/edit' class='custom-link-primary'>Edit</a>
				<span class='mx-2'>|</span>
				<a href='#' class='js-course-clone-btn custom-link-primary' data-course-id='$data->id'>Clone</a>
				<span class='mx-2'>|</span>
				<a href='/home/course/$data->slug' class='custom-link-primary'>View</a>");
            })
            ->editColumn('toggle', function ($data) {

                $status = $data->status == 0 ? "" : "checked";

                return "<input class='js-toggle' data-course-id='$data->id' type='checkbox' id='$data->slug-toggle-checkbox' $status data-switch='success' autocomplete='off'/>
					<label for='$data->slug-toggle-checkbox' class='mb-0' data-on-label='On' data-off-label='Off'></label>";
            })
            ->editColumn('topics', function ($data) {

                $topics = [];
                foreach ($data->topics as $topic)
                {
                    array_push($topics, $topic['title']);
                }

                return implode(", ", $topics);
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
			->filterColumn("topics", function($query, $keyword) {
				
				$query->whereHas("topics", function($sub) use ($keyword) {
					$sub->where("title", $keyword);
				});

			})
            ->rawColumns(['action', 'title', 'toggle', 'publish'])
            ->setRowAttr(['data-course-id' => function ($data) {

                return $data->id;
            }]);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Course $course
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Course $course) {

		if ( ! auth()->user()->hasRole(["super-admin", "admin"]) ) {
			return $course->where("user_id", auth()->user()->id);
		}
		
        return $course->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('courses-table')
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
            Column::make('title'),
            Column::make('status'),
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
        return 'Courses_' . date('YmdHis');
    }

}
