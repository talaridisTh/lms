<?php

namespace App\DataTables;

use App\AddCourseDataTable;
use App\Course;
use App\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class AddCoursesDataTable extends DataTable {

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query, Request $request)
    {

        $user = User::findOrFail($request->userId);
        $query = Course::query()->select();

        return datatables()
            ->eloquent($query)
            ->addColumn('action', function ($data) {

                return "<td><input class='btn btn-info js-button btn-sm my-1' value='Προσθηκη' data-course-id='{$data->id}'/></td>";
            })
//            ->editColumn('name', function ($data) {
//
//            })
            ->setRowAttr(['data-course-id' => function ($data) {
                return $data->id;
            }, 'data-user-id' => function ($data) use($user) {
                return $user->id;
            }]);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\AddCourseDataTable $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Course $model)
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
            ->setTableId('addcoursedatatable-table')
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
        return 'AddCourse_' . date('YmdHis');
    }

}
