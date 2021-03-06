<?php

namespace App\DataTables\Mail;

use App\Models\Mail;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class InstructorMailsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()::of($query)
			->addColumn('action', function($data) {

				$slug = Str::random(10);

				return "<div class='icheck-primary d-inline'>
					<input class='js-mail-checkbox' data-mail-id='$data->id' type='checkbox' id='$slug' autocomplete='off'>
					<label for='$slug'></label>
				</div>";
			})
			->addColumn("message", function($data) {

				$title = Str::limit($data->subject, 30);
				$content = Str::limit(strip_tags($data->content), 80);

				if ( is_null($data->sent_at) ) {
					return "<a href='/dashboard/email/compose/$data->id' class='mb-0 custom-primary'><strong title='$data->subject'>$title</strong> &nbsp; &nbsp; - &nbsp; &nbsp; $content</a>";
				}

				return "<a href='/dashboard/email/$data->id' class='mb-0 custom-primary'><strong title='$data->subject'>$title</strong> &nbsp; &nbsp; - &nbsp; &nbsp; $content</a>";
			})
			->addColumn("details", function($data) {

				return "<p class='time-cnt mb-0 text-right'><strong class='text-right'>". Carbon::parse($data->sent_at)->diffForHumans(null, false, true) ."</strong></p>
					<div class='tool-cnt text-left'>
						<i class='js-delete-mail mdi mdi-delete-circle-outline font-24 custom-danger cursor-pointer'
							data-mail-id='$data->id'></i>
					</div>";

			})
			->rawColumns(["action", "message", "details"]);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Mail $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Mail $model)
    {
		return $model->where("user_id", auth()->user()->id)
			->withTrashed()
			->where("instructor_deleted_at", null);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('mail/instructormails-table')
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
        return 'Mail/InstructorMails_' . date('YmdHis');
    }
}
