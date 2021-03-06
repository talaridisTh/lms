<?php

namespace App\DataTables\Mail;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class RecipientsDataTable extends DataTable
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

		//! ta select mpikan epidi ton pinaka 8a ton blepoun kai
		//! oi eisigites opote 8eloume na kripsoume prosopika stoixeia

		$query = User::role(["admin", "instructor", "student", "partner"])
			->whereIn("users.id", $recipients)->with([
				"courses" => function($subquery) {
					$subquery->select("courses.id", "courses.title");
				}, 
				"roles" => function($subquery) {
					$subquery->select("roles.id", "roles.name");
				}
			])
			// ->select("users.*");
			->select("users.id", "users.first_name", "users.last_name");

        return datatables()::of($query)
            ->addColumn('action', function($data) {

				$pattern = "/[-!$%^&*(@)_+|~=`{}\[\]:\";'<>?,.\/]/m";
                $slug = preg_replace($pattern, "", $data->email);

				return "<div class='icheck-primary d-inline'>
					<input id='recipient-$slug' class='js-recipient-checkbox'
						data-user-id='$data->id' type='checkbox' autocomplete='off'>
					<label for='recipient-$slug'></label>
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
			->addColumn("btn", function($data) {

				return "<i class='js-remove-recipient h3 px-2 pt-1 mdi mdi-delete-circle-outline cursor-pointer custom-danger'
					data-user-id='$data->id'></i>";

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
			->rawColumns(['action', 'btn']);
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
                    ->setTableId('mail/recipientsdatatable-table')
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
        return 'Mail/Recipients_' . date('YmdHis');
    }
}
