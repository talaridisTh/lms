<?php

namespace App\DataTables;

use App\Material;
use App\User;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class HistoryMaterialDatatable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {

        $data = auth()->user()->witchlist;

        $materialIds = $data->map(function ($material){
            return $material->pivot->material_id;
        });

        $materials = $materialIds->unique()->map(function ($material){
            return Material::findOrFaIL($material);
        });





        return datatables()::of($materials)
            ->addColumn('checkbox', function ($data) {
                return ("
             <div class='custom-control custom-checkbox'>
             <input type='checkbox' class='custom-control-input dt-checkboxes'>
             <label class='custom-control-label'> </label>
             </div>
                ");
            })
            ->addColumn('action', function ($data) {

                return ("
                    <a href='javascript:void(0);' class='action-icon'> <i class='mdi mdi-eye'></i></a>
                    <a href='javascript:void(0);' class='action-icon'> <i class='mdi mdi-square-edit-outline'></i></a>
                    <a href='javascript:void(0);' class='action-icon'> <i class='mdi mdi-delete'></i></a>
                ");
            })

            ->rawColumns(['checkbox', "action"]);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\HistoryMaterialDatatable $model
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
                    ->setTableId('historymaterialdatatable-table')
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
        return 'HistoryMaterial_' . date('YmdHis');
    }
}
