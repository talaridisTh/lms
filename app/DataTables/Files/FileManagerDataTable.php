<?php

namespace App\DataTables\Files;

use App\Models\Media;
use Illuminate\Support\Carbon;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class FileManagerDataTable extends DataTable {

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {

        $query = Media::where("type", "!=", 5)->with('mediaDetails');

        return datatables()::of($query)
            ->editColumn("original_name", function ($data) {

                $mediaDetails = $data->mediaDetails;
                $detailsTitle = null;
                $detailsSubtitle = "";
                $detailsCaption = "";
                $detailsDescription = "";
                $view = "";
                $publicUrl = !is_null($data->public_pass)
                    ? url("/pf/$data->public_pass/$data->name") : "";
                if ($data->type == 0) {
                    $view = "<a href='#' class='js-view-image custom-link-primary'
						data-toggle='modal' data-target='#image-light-room'
						data-source='$data->rel_path' draggable='false'>View</a>
						<span class='mx-2'>|</span>";
                }
                if (!is_null($mediaDetails)) {
                    $detailsTitle = $mediaDetails->title;
                    $detailsSubtitle = $mediaDetails->subtitle;
                    $detailsCaption = $mediaDetails->caption;
                    $detailsDescription = $mediaDetails->description;
                }
                $title = $detailsTitle ?? $data->original_name;

                return "
					<a href='#' class='h5 custom-link-primary' data-toggle='modal'
						data-target='#edit-file-modal' draggable='false'>$titlbuttons-to-right always-visiblee
					</a>
					<div class='d-none'>
						<input class='js-id-input' type='text' value='$data->id'>
						<input class='js-title-input' type='text' value='$detailsTitle'>
						<input class='js-subtile-input' type='text' value='$detailsSubtitle'>
						<input class='js-caption-input' type='text' value='$detailsCaption'>
						<input class='js-description-input' type='text' value='$detailsDescription'>
						<input class='js-public-url-input' type='text' value='$publicUrl'>
					</div>
					<p class='mb-1'>$data->name.$data->ext</p>
					<a href='#' class='custom-link-primary' data-toggle='modal' 
						data-target='#edit-file-modal' draggable='false'>Edit</a>
					<span class='mx-2'>|</span>
					$view
					<a href='$data->rel_path' class='custom-link-primary'
						draggable='false' download>Download</a>";
            })
            ->addColumn('image', function ($data) {

                $icons = Media::$icons;
                if ($data->type !== 0) {
                    foreach ($icons as $type => $icon) {
                        if (fnmatch("$type*", $data->ext)) {
                            return "<i class='h3 mdi {{ $icon }}' style='font-size: 90px;' title='{{ $data->ext }}'></i>";
                        }
                    }
                }

                return "<img class='img-fluid' style='max-width: 100px;' src='" . $data->thumbnailUrl("rel_path") . "' alt='$data->original_name' draggable='false'/>";
            })
            ->addColumn("title", function ($data) {

                if (!is_null($data->mediaDetails)) {

                    return $data->mediaDetails->title;

                }
            })
            ->editColumn("size", function ($data) {

                return number_format($data->size / 1000000, 2, ",", ".") . "MB";

            })
            ->editColumn('created_at', function ($data) {

                if (is_null($data->public_pass)) {
                    $status = ["icon" => "badge-outline-danger", "text" => "Inactive"];
                } else {
                    $status = ["icon" => "badge-outline-success", "text" => "Active"];
                }
                $date = Carbon::parse($data->created_at)->format("d-m-Y");
                $time = Carbon::parse($data->created_at)->format("H:i");

                return "<span class='js-badge badge " . $status['icon'] . " badge-pill'>" . $status['text'] . "</span>
					<p class='js-date mb-0 mt-1'>$date</p><p class='js-time mb-0'>$time</p>";
            })
            ->rawColumns(['original_name', 'image', 'created_at']);
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
