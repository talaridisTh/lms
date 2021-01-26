<?php

namespace App\DataTables\Materials;

use App\Models\Course;
use App\Models\Material;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CoursesDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query, Request $request)
    {
		$query->with([
			"topics" => function($subquery) {
				$subquery->select("topics.id", "topics.title");
			}
		]);
		$query->select("courses.*");

        return datatables()->eloquent($query)
            ->addColumn('checkbox', function ($data) {

                return "<div class='icheck-primary d-inline'>
							<input class='remainings-checkbox' data-course-id='$data->id'  type='checkbox' id='$data->title' autocomplete='off'>
							<label for='$data->title'></label>
						</div>";
            })
            ->addColumn('action', function ($data) {

                return "<button class='js-add-courses btn btn-primary'>Προσθήκη</button>";
			})
			->addColumn("topics", function($course) {

				return $course->topics->map(function($topic) {
					return $topic->title;
				})->implode(", ");
			})
			->filterColumn("topics.title", function($query, $keyword) {
				
				$query->whereHas("topics", function($sub) use ($keyword) {
					$sub->where("title", $keyword);
				});

			})
        	->rawColumns(['checkbox',"curator","action"])
        	->setRowAttr(['data-course-id' => function ($data) {
        	    return [$data->id];
            }]);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\AddCourseInsideMaterial $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Course $course, Request $request)
    {
		$courseIds = Material::find($request->materialId)->courses()->pluck("courses.id")->toArray();
		$courses = Course::whereNotIn("courses.id", $courseIds);
		
		if (auth()->user()->hasRole("instructor")) {
			$instructorCourses = auth()->user()->courses()->pluck("courses.id")->toArray();
			$courses->whereIn("courses.id", $instructorCourses);
		}

		return $courses;
        // return $course->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('addcourseinsidematerials-table')
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
        return 'AddCourseInsideMaterials_' . date('YmdHis');
    }
}
