<?php

namespace App\DataTables;

use App\User;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable {

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {

        $query = User::query()->select();

        return datatables()
            ->eloquent($query)
            ->addColumn('action', function ($data) {

                return "<td>{$data->getRoleNames()[0]}</td>";
            })
            ->editColumn('active', function ($data) {

                $active = $data->active == 0 ? "" : "checked";
                



                return "<input class='js-toggle' data-id='". $data->id ."' type='checkbox' id='". $data->first_name ."-toggle-checkbox' $active data-switch='bool' autocomplete='off'/>
					<label for='". $data->first_name ."-toggle-checkbox' data-on-label='On' data-off-label='Off'></label>";
            })
            ->rawColumns(['action', 'active'])
            ->setRowAttr(['data-user-id' => function ($data) {

                return $data->id;
            }]);
    }


    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
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
            ->setTableId('users-table')
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
            Column::make('first_name'),
            Column::make('active'),
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
        return 'Users_' . date('YmdHis');
    }

}
