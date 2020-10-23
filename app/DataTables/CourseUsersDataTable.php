<?php

namespace App\DataTables;

use App\Course;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CourseUsersDataTable extends DataTable {

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query, Request $request)
    {
		$query = Course::find( $request->courseId )->users()->with("roles")->get();

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

				if ( is_null($data->email_verified_at) ) {
					$badge .= "<span class='badge badge-outline-warning badge-pill ml-3'>Unverified</span>";
				}

				if ( $data->status === 0 ) {
					$badge .= "<span class='badge badge-outline-danger badge-pill ml-3'>Inactive</span>";
				}

				return "
					<span>$data->last_name $data->first_name</span>$badge
					<div class='mt-1'>
						<a href='/dashboard/users/$data->slug' class='custom-link-primary'>Edit</a>
					</div>
				";

			})
            ->addColumn('btn', function ($data) {

                return "
						<a href='/dashboard/users/$data->slug' class='custom-primary'><i class='h3 pt-1 mx-2 mdi mdi-magnify cursor-pointer' data-material-id='$data->id'></i></a>
						<i class='js-remove-user h3 px-2 pt-1 mdi mdi-delete-circle-outline cursor-pointer custom-danger' data-user-id='$data->id'></i>
					";
            })
            ->addColumn('role', function ($data) {

                return $data->roles[0]->id == 2 ? "Εισηγητής" : "Μαθητής";
            })
            ->setRowAttr(['data-user-id' => function ($data) {

                return $data->id;
            }, "data-user-slug" => function ($data) {

                return $data->slug;
            }])
            ->rawColumns(['action', 'last_name', 'btn']);
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
