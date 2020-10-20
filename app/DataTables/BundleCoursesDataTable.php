<?php

namespace App\DataTables;

use App\Bundle;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Carbon\Carbon;

class BundleCoursesDataTable extends DataTable {

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query, Request $request)
    {

        // dd($request->all());
        if (!is_null($request->startDate) && !is_null($request->endDate))
        {
            $query = Bundle::find($request->bundleId)->courses()
                ->where(function ($subquery) use ($request) {
                    $subquery->whereBetween('updated_at', [$request->startDate . "  00:00:00", $request->endDate . " 23:59:59"])
                        ->orWhereBetween('created_at', [$request->startDate . "  00:00:00", $request->endDate . " 23:59:59"]);
                }
                )->with("topics", "curator")->get();
        } else
        {
            $query = Bundle::find($request->bundleId)
                ->courses()->with("topics", "curator")->get();
        }

        return datatables()::of($query)
            ->addColumn('action', function ($data) {

                return (
                "<div class='icheck-primary d-inline'>
					<input class='js-course-checkbox' data-course-id='$data->id' type='checkbox' id='$data->slug' autocomplete='off'>
                    <label for='$data->slug'></label>
				</div>");
			})
			->editColumn('title', function($data) {



				if ( $data->status == 1 ) {
					$badge = "";
				}
				else {
					$badge = "<span class='badge badge-outline-danger badge-pill ml-3'>Inactive</span>";
				}

				return "<a href='/dashboard/course/$data->slug' class='h5 custom-link-primary'>$data->title </a>$badge
						<p class='mb-1'>$data->slug</p>
						<a href='/dashboard/course/$data->slug' class='custom-link-primary'>Edit</a>
						<span class='mx-2'>|</span>
						<a href='#' class='custom-link-primary'>View</a>";

			})
            ->editColumn('curator', function ($data) {

                if ($data->curator)
                {
                    $fullName = $data->curator->first_name . " " . $data->curator->last_name;
                } else
                {
                    $fullName = "";
                }

                return $fullName;
            })
            ->editColumn('topics', function ($data) {

                $topics = [];
                foreach ($data->topics as $topic)
                {
                    array_push($topics, $topic['title']);
                }

                return implode(", ", $topics);
			})
			->addColumn("btns", function($data) {

				return "<i class='js-remove-course h3 pt-1 mx-2 mdi mdi-delete-circle-outline custom-danger cursor-pointer'
					data-course-id='$data->id'></i>";
			})
            ->rawColumns(['action', 'title', 'btns'])
            ->setRowAttr(['data-course-id' => function ($data) {

                return $data->id;
            }]);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Bundle $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Bundle $model)
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
            ->setTableId('bundlecoursesdatatable-table')
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
        return 'BundleCourses_' . date('YmdHis');
    }

}
