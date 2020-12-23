<?php

namespace App\DataTables\Users;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Carbon;

class UsersDataTable extends DataTable {

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\datatableabstract
     */
    public function dataTable($query, Request $request) {

        if (!is_null($request->fromDate) && !is_null($request->toDate)) {

			$query = User::role(["admin", "instructor", "student", "partner"])
				->whereBetween("users.created_at", [$request->fromDate ."  00:00:00", $request->toDate ." 23:59:59"])
				->with("roles", "courses")->select("users.*");

		}

        return datatables()->of($query)
            ->addColumn('roles', function ($data) {
                $role = $data->getRoleNames()[0];
				switch ($role) {
					case "admin":
						return "Admin";
					case "instructor":
						return "Εισηγητής";
					case "partner":
						return "Partner";
					default:
						return "Μαθητής";
				}
            })
            ->addColumn('checkbox', function ($data) {

                return "<div class='icheck-primary d-inline'>
							<input class='js-user-checkbox' data-user-id='$data->id'  type='checkbox' id='$data->first_name' autocomplete='off'>
							<label for='$data->first_name'></label>
						</div>";
            })
            ->addColumn('courses', function (User $user) {
                return $user->courses->map(function ($course) {
                    return $course->title;
                })->implode(', ');
            })
            ->editColumn('status', function ($data) {
                $status = $data->status == 0 ? "" : "checked";
                $statusToggle = $data->status == 0 ? 0 : 1;

                return "<input  class='toggle-class' data-user-checked='$statusToggle' data-id='$data->id' type='checkbox' id='" . $data->first_name . "-toggle-checkbox' $status data-switch='success' autocomplete='off'/>
					<label for='" . $data->first_name . "-toggle-checkbox' class='mb-0' data-on-label='On' data-off-label='Off'></label>";
            })
            ->editColumn('last_name', function ($data) {

				return "<a href='/dashboard/users/$data->slug' class='h5 mb-0 custom-link-primary'>$data->last_name $data->first_name</a>
						<p class='mb-1'>$data->email</p>
						<a href='/dashboard/users/$data->slug' class='custom-link-primary'>Edit</a>";
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
			->filterColumn("courses.title", function($query, $keyword) {
				
				$query->whereHas("courses", function($sub) use ($keyword) {
					$sub->where("title", $keyword);
				});

			})
            ->rawColumns(['status', "checkbox", "courses", "last_name", "date"])
            ->setRowAttr([
                'data-user-id' => function ($data) {
                    return $data->id;
                },
                'data-user-slug' => function ($data) {
                    return $data->slug;
                }
            ]);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
    {
        return User::role(["admin", "instructor", "student", "partner"])
			->with("roles", "courses")->select("users.*");
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('users-table')
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
        return 'Users_' . date('YmdHis');
    }

}
