<?php

namespace App\DataTables\Materials;

use App\Material;
use App\Media;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class PDFDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query, Request $request)
    {

		if ( !is_null($request->materialId) ) {

			$activePDF = Material::find($request->materialId)->media()->where("usage", 4)->first();
	
			$query = Media::where("ext", "pdf")
				->where("id", "!=", $activePDF->id)
				->with("mediaDetails")->get();
		}
		else {
			$query = Media::where("ext", "pdf")
				->where("id", "!=", $request->pdfId)
				->with("mediaDetails")->get();
		}

        return datatables()::of($query)
			->addColumn('action', function($data) {

				if ( !is_null($data->mediaDetails) ) {
					$title = $data->mediaDetails->title;
				}
				else {
					$title = $data->original_name;
				}

				return "<button type='button' class='btn btn-primary js-change-pdf-btn'
					data-pdf-id='$data->id' data-pdf-title='$title' data-pdf-name='$data->name.$data->ext'>Προσθήκη</button>";
			})
			->editColumn("original_name", function($data) {

				if ( !is_null($data->mediaDetails) ) {
					$title = $data->mediaDetails->title;
				}
				else {
					$title = $data->original_name;
				}

				return "
					<div class='d-flex'>
						<i class='my-1 h3 mdi mdi-file-pdf-outline text-danger' title='$data->ext'></i>
						<div class='d-inline'>
							<a href='$data->rel_path' class='h5 mb-0 ml-2 custom-link-primary' download>$title</a>
							<p class='mb-0 ml-2'>$data->name.$data->ext</p>
						</div>
					</div>
				";
			})
			->editColumn("size", function($data) {

				return number_format($data->size / 1000000, 2, ",", ".") ."MB";

			})
			->rawColumns(['action', 'original_name']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \Media $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Media $model)
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
                    ->setTableId('remainingpdfdatatable-table')
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
        return 'RemainingPDF_' . date('YmdHis');
    }
}
