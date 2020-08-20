<?php

namespace App\DataTables;

use App\Course;
use App\Coursematerial;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class CourseMaterialsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query, Request $request)
    {

		$query = DB::table('materials')
			->join('course_material', 'materials.id', '=', 'course_material.material_id')
			->select('materials.id as materialId', 
				'materials.name', 
				'materials.active as materialActive', 
				'course_material.active as active', 
				'course_material.priority', 
				'materials.type', 
				'materials.slug', 
				'materials.updated_at as updated_at', 
				'materials.created_at as created_at', 
				'course_material.id')
			->where('course_id', $request->courseId);

        return Datatables::queryBuilder($query)
            ->addColumn('action', function($data) use ($request) {

				return "<div class='additions-cnt d-inline'>
							<div class='icheck-primary d-inline'>
								<input class='js-course-material-checkbox' data-material-id='$data->materialId' data-material-type='$data->type' type='checkbox' id='$data->slug' autocomplete='off'>
								<label for='$data->slug'></label>
							</div>
							<a class='text-success add-material' href='#'>
								<i class='mdi mdi-plus-circle-outline mr-1'></i>
							</a>
						</div>";

			})
			->editColumn('active', function($data) use ($request) {

				$active = $data->active == 0 ? "" : "checked";

				return "<input class='js-toggle' data-course-id='$request->courseId'
					type='checkbox' id='". $data->slug ."-toggle-checkbox' 
					data-material-id='$data->materialId' $active data-switch='bool' autocomplete='off'/>
					<label for='". $data->slug ."-toggle-checkbox' data-on-label='On' data-off-label='Off'></label>";

			})
			->editColumn('priority', function($data) {

				return "<div class='form-group'>
							<input type='text' class='form-control text-center js-sort-input' 
								data-material-id='$data->materialId' 
								data-current-priority='$data->priority' 
								value='$data->priority' autocomplete='off'>
						</div>";
			})
			->rawColumns(['action', 'active', 'priority'])
			->setRowAttr([ 'data-material-id' => function($data) {

				return  $data->materialId;

			}]);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \Course $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        // return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('coursematerials-table')
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
            Column::make('name'),
            Column::make('active'),
            Column::make('priority'),
            Column::make('type'),
            Column::make('updated_at'),
            Column::make('created_at'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'CourseMaterials_' . date('YmdHis');
    }
}
