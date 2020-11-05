<?php

namespace App\DataTables;

use App\Material;
use App\User;
use Carbon\Carbon;
use http\Env\Request;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class MaterialsDataTable extends DataTable {

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {



            if (!request()->from_date && !request()->to_date)
            {

                $data = Material::where("type", "!=", "Section")->with("courses")->get();
            } else
            {
                $data = Material::where(function ($subquery) {

					$subquery->where("type", "!=", "Section")
						->whereBetween('created_at', [request()->from_date . "  00:00:00", request()->to_date . " 23:59:59"])
						->get();
				})->get();
            }
        // }

        return DataTables::of($data)
            ->addColumn('action', function ($data) {

                return "<div class='icheck-primary d-inline'>
							<input class='js-material-checkbox js-user-checkbox' data-material-id='$data->id' type='checkbox' id='$data->slug' autocomplete='off'>
							<label for='$data->slug'></label>
						</div>";
            })
            ->addColumn('courses', function (Material $material) {
                return $material->courses->map(function ($course) {
                    return $course->title;
                })->implode(', ');
            })
            ->addColumn('id', function (Material $material) {
                return $material->id;
            })
            ->editColumn('title', function ($data) {

				if ( $data->type === "PDF" ) {
					return "<a href='/dashboard/view-pdf/$data->id' class='h5 custom-link-primary'>$data->title</a>
							<p class='mb-1'>$data->slug</p>
							<a href='/dashboard/view-pdf/$data->id' class='custom-link-primary'>View</a>";
				}

                return "<a href='/dashboard/material/$data->slug' class='h5 custom-link-primary'>$data->title</a>
						<p class='mb-1'>$data->slug</p>
						<a href='/dashboard/material/$data->slug' class='custom-link-primary'>Edit</a>
						<span class='mx-2'>|</span>
						<a href='#' class='custom-link-primary'>View</a>";
            })
            ->editColumn('status', function ($data) {

                $status = $data->status == 0 ? "" : "checked";

                return "<input data-status='$data->status'  class='js-toggle' data-material-id='$data->id' type='checkbox' id='" . $data->slug . "-toggle-checkbox' $status data-switch='success' autocomplete='off'/>
					<label for='" . $data->slug . "-toggle-checkbox' class='mb-0' data-on-label='On' data-off-label='Off'></label>";
            })
            ->rawColumns(['action', 'status', "courses", "title"])
            ->setRowAttr(['data-material-id' => function ($data) {

                return $data->id;
            }, 'data-material-slug' => function ($data) {
                return $data->slug;
            }
            ]);
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
            ->setTableId('materialsdatatable-table')
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
        return 'Materials_' . date('YmdHis');
    }

}
