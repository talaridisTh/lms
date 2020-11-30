<?php

namespace App\DataTables\Mail;

use App\Mail;
use App\User;
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
		$recipients = explode(",", $request->recipients);

		$query = User::whereNotIn("id", $recipients)->with("courses", "bundles", "roles");

        return datatables()::of($query)
            ->addColumn('action', function($data) {

				return "<div class='icheck-primary d-inline'>
					<input type='checkbox' id='select-all-users' autocomplete='off'>
					<label for='select-all-users'></label>
				</div>";
			})
			->addColumn("name", function($data) {

				return $data->last_name ." ". $data->first_name;

			})
			->addColumn("courses", function($data) {
				return $data->courses->map(function ($course) {
					return $course->title;
				})->implode(", ");
			})
			->addColumn("bundles", function($data) {
				return $data->bundles->map(function ($bundle) {
					return $bundle->title;
				})->implode(", ");
			})
			->addColumn("btn", function($data) {

				return "<button class='js-add-recipient btn btn-primary' data-user-id='$data->id'>Προσθήκη</button>";

			})
			->rawColumns(['action', 'btn']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \Mail $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Mail $model)
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
                    ->setTableId('mail/usersdatatable-table')
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
        return 'Mail/Users_' . date('YmdHis');
    }
}
