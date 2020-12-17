<?php

namespace App\DataTables\Users;

use App\Models\Course;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UserCoursesDataTable extends DataTable {

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query, Request $request)
    {
        $query = User::find($request->userId)->courses;

        return DataTables::of($query)
            // ->addColumn('action', function ($data) {
            //     return "<td><h3><i data-course-id='{$data->id}' data-course-title='{$data->title}' class=' js-button-delete h3 pt-1 uil uil-trash-alt cursor-pointer'></i></h3></td>";
            // })
            ->addColumn('checkbox', function ($data) {

                return "<div class='icheck-primary d-inline'>
							<input class='js-user-checkbox' data-course-id='$data->id' id='$data->slug' type='checkbox'autocomplete='off'>
							<label for='$data->slug' ></label>
						</div>";
            })
            ->editColumn('title', function($data) {

                return "<a href='/dashboard/courses/$data->slug/edit' class='h5 custom-link-primary'>$data->title</a>
						<p class='mb-1'>$data->slug</p>
						<a href='/dashboard/courses/$data->slug/edit' class='custom-link-primary'>Edit</a>
						<span class='mx-2'>|</span>
						<a href='#' class='custom-link-primary'>View</a>
						<span class='mx-2'>|</span>
						<a href='#' class='custom-link-primary js-button-delete' data-course-id='{$data->id}'>Remove</a>";

            })
            ->addColumn('publish', function ($data) {

                if ( $data->status == 1 ) {
                    if ( time() > strtotime($data->publish_at) && !is_null($data->publish_at) ) {
                        $status = ["icon" => "badge-outline-primary", "text" => "Published"];
                    }
                    else {
                        $status = ["icon" => "badge-outline-dark", "text" => "Scheduled"];
                    }
                }
                else {
                    $status = ["icon" => "badge-outline-danger", "text" => "Draft"];
                }

                $date = !is_null($data->publish_at) ? Carbon::parse($data->publish_at)->format("d-m-Y") : "";
                $time = !is_null($data->publish_at) ? Carbon::parse($data->publish_at)->format("H:i") : "";

                return "<span data-status=".$status['text']." class='js-badge badge ".$status['icon']." badge-pill'>".$status['text']."</span>
				<p class='js-date mb-0 mt-1'>$date</p><p class='js-time mb-0'>$time</p>";

            })

            ->setRowAttr(['data-course-id' => function ($data) {
                return [$data->id];
            }, 'data-course-title' => function ($data) {
                return $data->title;
            }])
            ->rawColumns(['action', "checkbox", "title", "publish"]);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\UsersProfileDataTable $model
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
            ->setTableId('usersprofiledatatable-table')
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
        return 'UsersProfile_' . date('YmdHis');
    }

}
