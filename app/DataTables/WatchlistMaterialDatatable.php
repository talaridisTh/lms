<?php

namespace App\DataTables;

use App\Models\User;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class WatchlistMaterialDatatable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {

        $query = auth()->user()->watchlistMaterial()->get();


        return datatables()::of($query)
            ->addColumn('checkbox', function ($data) {

                return ("
                     <div class='custom-control custom-checkbox'>
                         <input type='checkbox' class='custom-control-input dt-checkboxes'>
                         <label class='custom-control-label'> </label>
                     </div>
                ");
            })
            ->editColumn("created_at", function ($data) {
                return $data->pivot->created_at->diffForHumans();
            })
            ->editColumn("cover", function ($data) {
                return (
                "<img src='$data->cover' height='40' class='avatar-sm rounded-circle'/>"
                );
            })
            ->addColumn('action', function ($data) {

                return ("
                    <a href='javascript:void(0);' class='action-icon'> <i class='mdi mdi-eye'></i></a>
                    <a href='javascript:void(0);' class='action-icon'> <i class='mdi mdi-square-edit-outline'></i></a>
                    <a href='javascript:void(0);' class='action-icon'> <i class='mdi mdi-delete'></i></a>
                ");
            })
            ->rawColumns(['checkbox', "cover", "action"]);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\WatchlistMaterialDatatable $model
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
                    ->setTableId('watchlistmaterialdatatable-table')
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
        return 'WatchlistMaterial_' . date('YmdHis');
    }
}
