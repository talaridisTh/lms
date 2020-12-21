<?php

namespace App\DataTables\Courses;

use App\Models\Course;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Carbon;

class CourseUsersDataTable extends DataTable {

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query, Request $request)
    {
		$query = Course::find( $request->courseId )->users()->with("roles")
			->select("users.*");

        return datatables()::of($query)
            ->addColumn('action', function ($data) {

                $pattern = "/[-!$%^&*(@)_+|~=`{}\[\]:\";'<>?,.\/]/m";
                $slug = preg_replace($pattern, "", $data->email);

                return "<div class='icheck-primary d-inline'>
							<input class='js-active-user-checkbox' data-user-id='$data->id' type='checkbox' id='$slug' autocomplete='off'>
							<label for='$slug'></label>
						</div>";
			})
			->editColumn("last_name", function($data) {

				$badge = "";

				if ( $data->status === 0 ) {
					$badge = "<span class='badge badge-outline-danger badge-pill ml-3'>Inactive</span>";
				}

				return "
					<a href='/dashboard/users/$data->slug' class='h5 mb-0 custom-link-primary'>
						$data->last_name $data->first_name
					</a>$badge
					<p class='mb-1'>$data->email</p>
					<a href='/dashboard/users/$data->slug' class='custom-link-primary'>Edit</a>
					<span class='mx-2'>|</span>
					<a href='#' class='js-remove-user custom-link-primary'
						data-user-id='$data->id'>Remove</a>
				";

			})
            ->addColumn('role', function ($data) {

                return $data->getRoleNames()[0] === "instructor" ? "Εισηγητής" : "Μαθητής";
			})
			->addColumn("date", function($data) {

				if ( is_null($data->email_verified_at) ) {
					$status = ["icon" => "custom-pill-primary badge-outline-warning", "text" => "Unverified"];
				}
				else {
					$status = ["icon" => "custom-pill-primary badge-outline-success", "text" => "Verified"];
				}

				$date = Carbon::parse($data->created_at)->format("d-m-Y");
				$time = Carbon::parse($data->created_at)->format("H:i");

				return "<span class='js-badge badge ".$status['icon']." badge-pill'>".$status['text']."</span>
					<p class='js-date mb-0 mt-1'>$date</p><p class='js-time mb-0'>$time</p>";
			})
			->filterColumn("role", function($query, $keyword) {
				$query->whereHas("role", $keyword);
			})
            ->setRowAttr(['data-user-id' => function ($data) {

                return $data->id;
            }, "data-user-slug" => function ($data) {

                return $data->slug;
            }])
            ->rawColumns(['action', 'last_name', 'date']);
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
            ->setTableId('courseusersdatatable-table')
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
        return 'CourseUsers_' . date('YmdHis');
    }

}
