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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function show(Topic $topic)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function edit(Topic $topic)
    {
        //
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
