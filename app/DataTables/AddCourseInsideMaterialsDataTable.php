<?php

namespace App\DataTables;

use App\AddCourseInsideMaterial;
use App\Course;
use App\Material;
use App\User;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class AddCourseInsideMaterialsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query )
    {



        $query = Course::notInMaterialsCourse(request()->materialId);


        return DataTables::of($query)
            ->addColumn('checkbox', function ($data) {

                return "<div class='icheck-primary d-inline'>
							<input class='remainings-checkbox' data-course-id='$data->id'  type='checkbox' id='$data->title' autocomplete='off'>
							<label for='$data->title'></label>
						</div>";
            })
            ->addColumn('curator', function ($data) {

				if ( is_null($data->user_id) ) {
					return "-";
				}

                return User::find($data->user_id)->fullName;
            })
            ->addColumn('action', function ($data) {

                return "<button class='js-add-courses btn btn-primary'>Προσθήκη</button>";
            })
        ->rawColumns(['checkbox',"curator","action"])
            ->setRowAttr(['data-course-id' => function ($data) {
                return [$data->id];
            }]);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\AddCourseInsideMaterial $model
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
                    ->setTableId('addcourseinsidematerials-table')
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
        return 'AddCourseInsideMaterials_' . date('YmdHis');
    }
}
