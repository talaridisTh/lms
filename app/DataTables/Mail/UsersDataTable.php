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

		$query = User::role(["admin", "instructor", "student", "partner"])
			->whereNotIn("users.id", $recipients)->with("courses", "bundles", "roles")
			->select("users.*");

        return datatables()->of($query)
            ->addColumn('action', function($data) {

				$pattern = "/[-!$%^&*(@)_+|~=`{}\[\]:\";'<>?,.\/]/m";
				$slug = preg_replace($pattern, "", $data->email);
				
				return "<div class='icheck-primary d-inline'>
					<input type='checkbox' id='$slug-checkbox' data-user-id='$data->id'
						class='js-user-checkbox' autocomplete='off'>
					<label for='$slug-checkbox'></label>
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
			->addColumn("role", function($data) {

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
			->filterColumn("courses.title", function($query, $keyword) {
				
				$query->whereHas("courses", function($sub) use ($keyword) {
					$sub->where("title", $keyword);
				});

			})
			->filterColumn("bundles.title", function($query, $keyword) {
				
				$query->whereHas("bundles", function($sub) use ($keyword) {
					$sub->where("title", $keyword);
				});

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
