<?php

namespace App\DataTables;

use App\User;
use http\Env\Request;
use Illuminate\Support\Facades\DB;
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
            $data = User::all();

        } else
        {
            $data = User:: whereBetween('created_at', [request()->from_date."  00:00:00", request()->to_date." 23:59:59"])->get();

        }

        return DataTables::of($data)
            ->addColumn('action', function ($data) {


                return "{$data->getRoleNames()[0]}";
            })
            ->addColumn('activeNum', function ($data) {

                return $data->status;
            })
            ->addColumn('chexbox', function ($data) {

                return "<div class='icheck-primary d-inline'>
							<input class='js-user-checkbox' data-user-id='$data->id'  type='checkbox' id='$data->first_name' autocomplete='off'>
							<label for='$data->first_name'></label>
						</div>";
            })
            ->addColumn('dateChange', function ($data) {

                return $data->created_at->diffForHumans();
            })
            ->addColumn('allcourse', function ($data) {

                $user = User::findOrFail($data->id);
                $query = $user->courses()->get();

                return $query;
            })
            ->editColumn('status', function ($data) {

                $status = $data->status == 0 ? "" : "checked";

                return "<input  class='toggle-class' data-user-checked='$status' data-id='" . $data->id . "' type='checkbox' id='" . $data->first_name . "-toggle-checkbox' $status data-switch='bool' autocomplete='off'/>
					<label for='" . $data->first_name . "-toggle-checkbox' data-on-label='On' data-off-label='Off'></label>";
            })
            ->editColumn('first_name', function($data) {

                return "<a href='/dashboard/users/$data->slug' class='h5 custom-link-primary'><p>$data->first_name</p></a>
						<a href='/dashboard/users/$data->slug' class='custom-link-primary'>Edit</a>
						<span class='mx-2'>|</span>
						<a href='#' class='custom-link-primary'>View</a>";

            })
            ->editColumn('avatar', function ($data) {
                return "<div>
                            <img src='$data->avatar' class='avatar-sm rounded' alt='$data->avatar' >
                            <div class=' mt-2  extraContentEdit'>
                                <span class='hover cursor-pointer  edit'> Edit</span> | <span class='hover cursor-pointer '> Delete</span>
                            </div>
                       </div> ";
            })
            ->rawColumns(['action', 'status', "avatar", "activeNum", "chexbox",'dateChange',"allcourse","first_name"])
            ->setRowAttr([
                'data-user-id' => function($data) {
                    return $data->id;
                },
                'data-user-slug' => function($data) {
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
