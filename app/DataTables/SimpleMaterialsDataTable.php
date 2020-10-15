<?php

namespace App\DataTables;

use App\Material;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SimpleMaterialsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
		$query = Material::select("id", "title", "subtitle", "cover")->where( function($query) {
			$query->where("type", "Lesson")
				->where("status", 1)->get();
		})->get();

        return datatables()::of($query)
			->addColumn('action', function($data) {

				return "<i class='js-add-material-banner p-2 font-20 mdi mdi-plus-circle-outline cursor-pointer'
					data-model='App\Material' data-model-id='$data->id' data-model-cover='$data->cover'
					data-model-title='$data->title' data-model-subtitle='$data->subtitle'></i>";

			})
			->rawColumns(["action"]);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \Material $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Material $model)
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
                    ->setTableId('simplematerialdatatable-table')
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
        return 'SimpleMaterial_' . date('YmdHis');
    }
}
