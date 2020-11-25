<?php

namespace App\DataTables;

use App\Mail;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class MailsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
		$query = User::find(Auth::user()->id)->mails;

        return datatables()::of($query)
			->addColumn('action', function($data) {
				 
				$slug = Str::random(10);

				return "<div class='icheck-primary d-inline'>
					<input class='js-mail-checkbox' data-mail-id='$data->id' type='checkbox' id='$slug' autocomplete='off'>
					<label for='$slug'></label>
				</div>";
			})
			->addColumn("details", function($data) {

				$title = Str::limit($data->subject, 30);
				$content = Str::limit(strip_tags($data->content), 80);

				return "<strong title='$data->subject'>$title</strong> &nbsp; &nbsp; - &nbsp; &nbsp; <span title='".strip_tags($data->content)."'>$content</span>";
			})
			->rawColumns(["action", "details"]);
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
                    ->setTableId('mailsdatatable-table')
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
        return 'Mails_' . date('YmdHis');
    }
}
