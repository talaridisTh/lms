<?php

namespace App\DataTables;

use App\Course;
use App\CourseInsideMaterial;
use App\Material;
use App\Topic;
use App\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CourseInsideMaterialsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query, Request $request)
    {

        $query = Material::findOrFail($request->materialId)->courses()->with("topics")->get();

        return datatables()::of($query)
            ->addColumn('checkbox', function ($data) {
                return "<div class='icheck-primary d-inline'>
							<input class='js-course-inside-material'  id='$data->title' type='checkbox'  autocomplete='off'>
							<label for='$data->title'></label>
						</div>";
            })
            ->addColumn('topics', function ($data) {

                $collection =  $data->topics->map(function($top){
                    return $top->title ;
                });

                return $collection->implode(", ");

            })
            ->addColumn('humans', function ($data) {

                return $data->created_at->diffForHumans();

            })
            ->addColumn('active', function ($data) {

                return $data->status;

            })
            ->editColumn('curator', function ($data) {

                return  User::find($data->user_id)->fullName;

            })
            ->editColumn('updated_at', function ($data) {

                return $data->updated_at->diffForHumans();

            })
            ->rawColumns(["checkbox","topics","humans","active"])
            ->setRowAttr([
                'data-course-id' => function ($data) {
                    return $data->id;
                }
            ]);

    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\CourseInsideMaterial $model
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
            ->setTableId('courseinsidematerials-table')
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
        return 'CourseInsideMaterials_' . date('YmdHis');
    }
}
