<?php

namespace App\DataTables;

use App\Course;
use App\Topic;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\DB;

class CoursesDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query, Request $request)
    {

		$query = Course::with("topics", "curator");

		if ( !is_null($request->startDate) && !is_null($request->endDate) && is_null($request->topicId) ) {
			$query = Course::with("topics", "curator")
			->where( function($subquery) use ($request) {
				$subquery->whereBetween('updated_at', [ $request->startDate ."  00:00:00", $request->endDate ." 23:59:59"])
				->orWhereBetween('created_at', [ $request->startDate ."  00:00:00", $request->endDate ." 23:59:59"]);
			});
		}
		elseif ( is_null($request->startDate) && is_null($request->endDate) && !is_null($request->topicId) ) {
			
			$query = Topic::find( $request->topicId )->courses();
			
		}
		elseif ( !is_null($request->startDate) && !is_null($request->endDate) && !is_null($request->topicId) ) {
			
			$query = Topic::find( $request->topicId )->courses()
				->where( function($subquery) use ($request) {
					$subquery->whereBetween('updated_at', [ $request->startDate ."  00:00:00", $request->endDate ." 23:59:59"])
						->orWhereBetween('created_at', [ $request->startDate ."  00:00:00", $request->endDate ." 23:59:59"]);
				});
				

		}

        return datatables()
            ->eloquent($query)
			->addColumn('action', function($data) {
				
				return "<div class='icheck-primary d-inline'>
							<input class='js-course-checkbox' data-course-id='$data->id' data-course-title='$data->title' type='checkbox' id='$data->slug' autocomplete='off'>
							<label for='$data->slug'></label>
						</div>";

			})
			->editColumn('title', function($data) {

				return "<a href='/dashboard/course/$data->id' class='h5 custom-link-primary'>$data->title</a>
				<p class='mb-1'>$data->slug</p>
				<a href='/dashboard/course/$data->id' class='custom-link-primary'>Edit</a>
				<span class='mx-2'>|</span>
				<a href='#' class='js-course-clone-btn custom-link-primary' data-course-id='$data->id'>Clone</a>
				<span class='mx-2'>|</span>
				<a href='#' class='custom-link-primary'>View</a>";

			})
			->editColumn('status', function($data) {

				$status = $data->status == 0 ? "" : "checked";

				return "<input class='js-toggle' data-course-id='$data->id' type='checkbox' id='$data->slug-toggle-checkbox' $status data-switch='bool' autocomplete='off'/>
					<label for='$data->slug-toggle-checkbox' class='mb-0' data-on-label='On' data-off-label='Off'></label>";

			})
			->editColumn('topic', function( $data ) {

				$topics = [];

				foreach ( $data->topics as $topic ) {
					array_push($topics, $topic['title']);
				}

				return implode(", ", $topics);

			})
			->editColumn('curator', function($data) {

				if ( $data->curator ) {
					$fullName = $data->curator->first_name ." ". $data->curator->last_name;
				}
				else {
					$fullName = "";
				}

				return $fullName;

			})
			->editColumn('updated_at', function($data) {

				return Carbon::parse( $data->updated_at)->format( "d / m / Y" );

			})
			->editColumn('created_at', function($data) {

				return Carbon::parse( $data->created_at)->format( "d / m / Y" );

			})
			->rawColumns(['action', 'title', 'status'])
			->setRowAttr([ 'data-course-id' => function($data) {

				return  $data->id;

			}]);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Course $model
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
