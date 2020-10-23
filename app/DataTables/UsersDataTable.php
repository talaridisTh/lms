<?php

namespace App\DataTables;

use App\User;
use http\Env\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\DeclareDeclare;
use Spatie\Permission\Contracts\Role;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable {

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\datatableabstract
     */
    public function dataTable($query)
    {

        if (!request()->from_date && !request()->to_date)
        {



            $data = User::with(["roles", "courses"])->whereHas(
            'roles', function ($q) {
            $q->where('name', "!=", 'guest');
        }
        )->get();



//            $data = User::with("courses")->get();
        } else
        {
            $data = User::whereBetween('users.created_at', [request()->from_date . "  00:00:00", request()->to_date . " 23:59:59"])
                ->with(["roles", "courses"])->select("users.*");
        }

        return DataTables::of($data)
            ->addColumn('roles', function (User $user) {
                return $user->roles->map(function ($role) {
                    return $role->name;
                })->implode(', ');
            })
            ->addColumn('chexbox', function ($data) {

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

                return "<input  class='toggle-class' data-user-checked='$status' data-id='" . $data->id . "' type='checkbox' id='" . $data->first_name . "-toggle-checkbox' $status data-switch='bool' autocomplete='off'/>
					<label for='" . $data->first_name . "-toggle-checkbox' data-on-label='On' data-off-label='Off'></label>";
            })
            ->editColumn('last_name', function ($data) {

                return "<p>$data->last_name</p>
						<a href='/dashboard/users/$data->slug' class='custom-link-primary'>Edit</a>
						<span class='mx-2'>|</span>
						<a href='#' class='custom-link-primary'>View</a>";
            })
            ->rawColumns(['roles', 'status', "activeNum", "chexbox", "courses", "last_name"])
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

        return $model->all();
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
            Column::make('first_name'),
            Column::make('status'),
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
