<?php

namespace App\DataTables;

use App\Material;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;


class RemainingMaterialsDataTable extends DataTable
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
			->join('material_topic', 'materials.id', '=', 'material_topic.material_id')
			->join('topics', 'material_topic.topic_id', '=', 'topics.id')
			->select( 'materials.id',
				'topics.name as topicName',
				'materials.name as materialName',
				'materials.type',
				'materials.slug', 
			)
			->where('active', 1)
			->whereNotIn('materials.id', 
				function($subquery) use ($request) {

					$subquery->select('material_id')
						->from('course_material')
						->where('course_id', $request->courseId)
						->get();

				}
			);

        return Datatables::of($query)
            ->addColumn('action', function($data) {

				return "<div class='icheck-primary d-inline'>
							<input class='js-remainings-checkbox' data-material-id='$data->id' data-material-type='$data->type' type='checkbox' id='$data->slug' autocomplete='off'>
							<label for='$data->slug'></label>
						</div>";

			})
			->addColumn('addBtn', function($data) {

				return "<button type='button' class='btn btn-primary js-add-material-btn' data-material-id='$data->id' data-material-type='$data->type'>Προσθήκη</button>";

			})
			->setRowClass('last-column-p-10')
			->rawColumns(['action', 'addBtn']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\RemainingMaterial $model
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
                    ->setTableId('remainingmaterials-table')
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
            Column::make('type'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'RemainingMaterials_' . date('YmdHis');
    }
}
