<?php

namespace App\DataTables\Files;

use App\Models\Media;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

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
					["mediable_id", $request->id],
					["mediable_type", $request->namespace]
				])
				->get();
		})
		->get();

        return datatables()::of($query)
			->addColumn('action', function($data) {
				return "<button type='button' class='btn btn-primary js-add-file-btn' data-file-id='$data->id'>Προσθήκη</button>";
			})
			->editColumn("original_name", function($data) {

				$icons = Media::$icons;

				foreach ($icons as $type => $icon) {
					if ( fnmatch("$type*", $data->ext ) && $data->ext != "mp3") {
						$label = "<i class='my-1 h3 mdi $icon' title='$data->ext'></i>";
						break;
					}
					elseif ( $data->ext === "mp3" ) {
						$label = "
							<i class='js-audio-btn my-1 h3 mdi mdi-play-circle-outline cursor-pointer' data-audio-status='paused'></i>
							<audio class='js-audio'>
								<source src='$data->rel_path' type='$data->file_info'>
							</audio>
						";
						break;
					}
				}
				return "
					<div class='d-flex'>
						$label
						<div class='d-inline'>
							<a href='$data->rel_path' class='mb-0 ml-2 custom-link-primary' download>$data->original_name</a>
							<p class='mb-0 ml-2'>$data->name.$data->ext</p>
						</div>
					</div>
				";
			})
			->editColumn("size", function($data) {

				return number_format($data->size / 1000000, 2, ",", ".") ."MB";

			})
			->rawColumns(['action', 'original_name', 'ext']);
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
