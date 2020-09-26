<?php

namespace App\DataTables;

use App\Material;
use App\Media;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\DB;

class FilesDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query, Request $request)
    {
		$query = Media::where("type", 1)->whereNotIn("id", function($subquery) use ($request) {
			$subquery->select("media_id")->from("mediables")
				->where([
					["mediable_id", $request->materialId],
					["mediable_type", Material::class]
				])
				->get();
		})
		->get();

        return datatables()::of($query)
			->addColumn('action', function($data) {
				return "<button type='button' class='btn btn-primary js-add-file-btn' data-file-id='$data->id'>Προσθήκη</button>";
			})
			->editColumn("ext", function($data) {
				$icons = [
					"mp3" => "mdi-music-clef-treble",
					"pdf" => "mdi-file-pdf-outline text-danger",
					"doc" => "mdi-file-document-outline text-teal",
					"odt" => "mdi-file-document-outline text-teal",
					"rtf" => "mdi-file-document-outline text-teal",
					"xl" => "mdi-file-table-box text-success",
					"ods" => "mdi-file-table-box text-success",
					"pp" => "mdi-file-powerpoint-outline text-orange",
					"odp" => "mdi-file-powerpoint-outline text-orange",
					"zip" => "mdi-folder-zip-outline text-warning",
				];

				foreach( $icons as $type => $icon ) {
					if ( fnmatch("$type*", $data->ext ) ) {
						return "<i class='h3 mdi {{ $icon }}' title='{{ $data->ext }}'></i>";
					}
				}

			})
			->editColumn("size", function($data) {

				return number_format($data->size / 1000000, 2, ",", ".") ."MB";

			})
			->rawColumns(['action', 'ext']);
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
                    ->setTableId('filesdatatable-table')
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
        return 'Files_' . date('YmdHis');
    }
}
