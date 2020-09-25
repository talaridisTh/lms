<?php

namespace App\DataTables;

use App\Media;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class FileManagerDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {

		$query = Media::with('mediaDetails');

        return datatables()::of($query)

			->editColumn("original_name", function($data) {

				$details = $data->mediaDetails;

				if ( !$details ) {
					return "
						<a href='#' class='h5 custom-link-primary' data-title='' data-subtitle=''
							data-toggle='modal' data-target='#edit-file-modal' data-caption='' data-description=''
							data-file-id='$data->id'
						>$data->original_name</a>
							<p>$data->name</p>";
				}

				return "
					<a href='#' class='h5 custom-link-primary' data-title='$details->title'
						data-subtitle='$details->subtitle' data-caption='$details->caption'
						data-description='$details->description' data-toggle='modal'
						data-file-id='$data->id' data-target='#edit-file-modal'
					>$data->original_name</a>
						<p>$data->name</p>";
			})
			->editColumn("type", function($data) {
				$type = explode( "/", $data->file_info );
				return ucfirst( $type[0] );
			})
			->addColumn('image', function($data) {

				if ( is_null($data->thumbnail_path) ) {
					return "<i class='h1 mdi mdi-file-document-outline'></i>";
				}

				return "<img class='img-fluid' style='max-width: 120px;' src='".url($data->thumbnail_path)."' alt='$data->original_name' />";

			})
			->editColumn("size", function($data) {

				return number_format($data->size / 1000000, 2, ",", ".") ."MB";

			}) 
			->rawColumns(['original_name', 'image', 'type']);
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
                    ->setTableId('filemanagerdatatable-table')
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
        return 'FileManager_' . date('YmdHis');
    }
}
