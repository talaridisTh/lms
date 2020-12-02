<?php

namespace App\DataTables\Options;

use App\Option;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class OptionsDataTable extends DataTable
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
            ->editColumn('name', function($data) {

				if ( !json_decode($data->value, JSON_ERROR_SYNTAX) ) {
					return "<a href='#' class='js-quick-edit h5 custom-link-primary cursor-pointer js-title'>$data->name</a>
						<div class='js-edit-cnt d-none'>
							<div class='form-group'>
								<label>Τίτλος</label>
								<input type='text' class='js-option-name form-control' value='$data->name' placeholder='Εισάγετε Όνομα...'>
								<div class='invalid-feedback'>
									Το πεδίο είναι υποχρεωτικό.
								</div>
							</div>
							<div class='form-group'>
								<label>Τιμή</label>
								<textarea class='js-option-value form-control' rows='5' placeholder='Εισάγετε Τιμή...'>$data->value</textarea>
								<div class='invalid-feedback'>
									Το πεδίο είναι υποχρεωτικό.
								</div>
							</div>
							<div class='text-right'>
								<button class='js-save btn btn-primary' data-option-id='$data->id'>Save</button>
								<button class='js-cancel btn btn-light'>Cancel</button>
							</div>
						</div>";
				}
				else {
					return "<a href='/dashboard/option/$data->id/show-json' class='js-quick-edit h5 custom-link-primary cursor-pointer'>$data->name</a>";
				}
			})
			->addColumn("action", function($data) {
				return "<i class='js-remove-option h3 pt-1 mx-2 mdi mdi-delete-circle-outline custom-danger cursor-pointer'
				data-option-id='$data->id'></i>";
			})
			->rawColumns(['name', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \Option $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Option $model)
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
                    ->setTableId('optionsdatatable-table')
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
        return 'Options_' . date('YmdHis');
    }
}
