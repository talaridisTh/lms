<?php

namespace App\DataTables\Files;

use App\Models\Media;
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

		$query = Media::with('mediaDetails')->get();

        return datatables()::of($query)
			->editColumn("original_name", function($data) {

				$details = $data->mediaDetails;
				$view = "";
				$dNone = is_null($data->public_pass) ? "d-none" : "";

				if ( $data->type == 0 ) {
					$view = "<a href='#' class='js-view-image custom-link-primary'
						data-toggle='modal' data-target='#image-light-room'
						data-source='$data->rel_path' draggable='false'>View</a>
						<span class='mx-2'>|</span>";
				}

				if ( !$details ) {
					return "
						<a href='#' class='h5 custom-link-primary' data-toggle='modal'
							data-target='#edit-file-modal' data-file-id='$data->id'
							draggable='false'>
							$data->original_name
						</a>
						<p>$data->name.$data->ext</p>
						<a href='#' class='custom-link-primary' data-toggle='modal' 
							data-target='#edit-file-modal' data-file-id='$data->id'
							draggable='false'>Edit</a>
						<span class='mx-2'>|</span>
						$view
						<a href='$data->rel_path' class='custom-link-primary'
							draggable='false' download>Download</a>
							<span class='mx-2 js-copy-url-separator copy-url-separator $dNone'>|</span>
							<a href='#' class='js-copy-url copy-url custom-link-primary'
								data-url='".url("/pf/$data->public_pass/$data->name")."'
								draggable='false'>Copy Url</a>";
				}

				return "
					<a href='#' class='h5 custom-link-primary' data-title='$details->title'
						data-subtitle='$details->subtitle' data-caption='$details->caption'
						data-description='$details->description' data-toggle='modal'
						data-file-id='$data->id' data-target='#edit-file-modal'
						draggable='false'>
						$details->title
					</a>
					<p>$data->name.$data->ext</p>
					<a href='#' class='custom-link-primary' data-toggle='modal' 
						data-target='#edit-file-modal' data-file-id='$data->id'
						data-title='$details->title' data-subtitle='$details->subtitle'
						data-caption='$details->caption' data-description='$details->description'
						draggable='false'>Edit</a>
					<span class='mx-2'>|</span>
					$view
					<a href='$data->rel_path' class='custom-link-primary'
						draggalbe='false' download>Download</a>
					<span class='mx-2 js-copy-url-separator copy-url-separator $dNone'>|</span>
					<a href='#' class='js-copy-url copy-url custom-link-primary'
						data-url='".url("/pf/$data->public_pass/$data->name")."'
						draggable='false'>Copy Url</a>";
			})
			->addColumn('image', function($data) {

				$icons = Media::$icons;

				if ( $data->type !== 0 ) {
					foreach( $icons as $type => $icon ) {
						if ( fnmatch("$type*", $data->ext ) ) {
							return "<i class='h3 mdi {{ $icon }}' style='font-size: 105px;' title='{{ $data->ext }}'></i>";
						}
					}
				}

				return "<img class='img-fluid' style='max-width: 120px;' src='".$data->thumbnailUrl("rel_path")."' alt='$data->original_name' />";
			})
			->editColumn("size", function($data) {

				return number_format($data->size / 1000000, 2, ",", ".") ."MB";

			})
			->editColumn("public_pass", function($data) {

				$checked = is_null($data->public_pass) ? "" : "checked";

				return "<input class='js-public-pass-toggle' data-media-id='$data->id'
					type='checkbox' id='$data->name-pass-toggle' data-switch='success' $checked autocomplete='off'>
				<label for='$data->name-pass-toggle' class='mb-0' data-on-label='On' data-off-label='Off'></label>";
			})
			->rawColumns(['original_name', 'image', 'public_pass']);
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
