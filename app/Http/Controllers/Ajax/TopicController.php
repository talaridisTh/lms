<?php

namespace App\Http\Controllers\Ajax;

use App\DataTables\Topics\TopicsDataTable;
use App\Http\Controllers\Controller;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(TopicsDataTable $dataTable)
    {
        return $dataTable->render('topics.index');
    }

    public function topicSearch(Request $request) {
		$topics = Topic::where("title", "LIKE", "%$request->search%")
			->select("id", "title")->paginate(10);

		$result = [];
		$result["results"] = [];

		foreach($topics as $key => $topic) {
			if ($topics->currentPage() === 1 && $key === 0) {

				array_push($result['results'], [
					"id" => " ",
					"text" => "Όλα τα Topics"
				]);
			}
			array_push($result['results'], [
				"id" => $topic->title,
				"text" => $topic->title
			]);
		}

		$result["pagination"] = [
			"more" => $topics->currentPage() !== $topics->lastPage()
		];

		echo json_encode($result);
	}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Topic $topic)
    {
		$request->validate([
			'title' => 'required|unique:topics'
		]);

		$topic->title = $request->title;
		$topic->slug = Str::slug($request->title, "-");
		$topic->save();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function destroy( $ids )
    {
		$ids = explode(",", $ids);

		foreach ( $ids as $id ) {

			Topic::find( $id )->delete();

		}

    }

    public function changeColor(Request $request)
    {

        Topic::findOrFail($request->topicId)->update(["color"=>$request->color]);

    }
}
