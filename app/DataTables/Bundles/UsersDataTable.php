<?php

namespace App\DataTables\Bundles;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query, Request $request)
    {
		$query = Role::find(4)->users()->where("status", 1)
			->whereNotIn("id", function($subquery) use ($request) {

				$subquery->select("user_id")->from("bundle_user")
					->where("bundle_id", $request->bundleId)->get();

			})->get();

        return datatables()::of($query)
			->addColumn('action', function($data) {

				return "<div class='icheck-primary d-inline ml-2'>
							<input class='js-remaining-user-checkbox' data-user-id='$data->id' type='checkbox' id='$data->slug' autocomplete='off'>
							<label for='$data->slug'></label>
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
			->addColumn('btn', function($data) {

				return "<button type='button' class='btn btn-primary js-add-user-btn' data-user-id='$data->id'>Προσθήκη</button>";

			})
			->rawColumns(['action', 'last_name', 'btn']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \User $model
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
                    ->setTableId('addbundleusersdatatable-table')
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
        return 'AddBundleUsers_' . date('YmdHis');
    }
}
