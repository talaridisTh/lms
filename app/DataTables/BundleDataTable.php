<?php

namespace App\DataTables;

use App\Bundle;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class BundleDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
		$query = Bundle::query()->select( 'id', 'name', 'active', 'slug', 'updated_at', 'created_at' );

        return datatables()
            ->eloquent($query)
            ->addColumn('action', function($data) {
				
				return "<div class='icheck-primary d-inline'>
							<input class='js-bundle-checkbox' data-bundle-id='$data->id' type='checkbox' id='$data->slug' autocomplete='off'>
							<label for='$data->slug'></label>
						</div>";

			})
			->editColumn('active', function($data) {

				$active = $data->active == 0 ? "" : "checked";

				return "<input class='js-toggle' data-bundle-id='$data->id' type='checkbox' id='". $data->slug ."-toggle-checkbox' $active data-switch='bool' autocomplete='off'/>
					<label for='". $data->slug ."-toggle-checkbox' data-on-label='On' data-off-label='Off'></label>";

			})
			->rawColumns(['action', 'active'])
			->setRowAttr([ 'data-bundle-id' => function($data) {

				return  $data->id;

			}]);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \Bundle $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Bundle $model)
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
                    ->setTableId('bundledatatable-table')
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
        return 'Bundle_' . date('YmdHis');
    }
}
