<?php

namespace App\Http\Controllers;

use App\Bundle;
use App\Topic;
use App\Media;
use App\Http\Requests\BundleCourseRequest;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BundleController extends Controller
{

    public function index()
    {
        return view('admin/bundles/bundlesMain');
    }


    public function create()
    {
		$data = [
			'media' => Media::where("type", 0)->orderBy("id", "desc")->paginate(18)
		];

        return view('admin/bundles/newBundle')->with($data);
    }

    public function store(Request $request)
    {
		$request->validate([
			'title' => 'required|unique:bundles'
		]);

		if ( isset($request->publishDate) ) {
			$publishDate = Carbon::parse( $request->publishDate )->format("Y-m-d H:i:s");
		}
		else {
			$publishDate = null;
		}

		$fields = [
			"summary" => isset($request->summaryEditor) ? 1 : 0,
			"description" => isset($request->descriptionEditor) ? 1 : 0
		];

		$bundle = new Bundle;
		$bundle->title = $request->title;
		$bundle->subtitle = $request->subtitle;
		$bundle->summary = $request->summary;
		$bundle->description = $request->description;
		$bundle->fields = json_encode($fields);
		$bundle->publish_at = $publishDate;
		$bundle->status = 0;
		$bundle->slug = Str::slug($request->title, "-");

		$bundle->save();

		return redirect( "/dashboard/bundle/$bundle->slug" );
    }

    public function show(Bundle $bundle = null)
    {

		if ( is_null($bundle) ) {
			$publish = "";
		}
		else {
			$publish = is_null($bundle->publish_at) ? null : Carbon::parse( $bundle->publish_at )->format("d-m-Y H:i");
		}

		$data = [
			'bundle' => $bundle,
			'media' => Media::where("type", 0)->orderBy("id", "desc")->paginate(18),
			'topics' => Topic::all("title"),
			'publish' => $publish,
			"fields" => json_decode($bundle->fields)
		];

        return view("admin/bundles/bundle")->with($data);
    }


    public function edit(Bundle $bundle)
    {
        //
    }


    public function update(Request $request, Bundle $bundle)
    {

		if ( isset($request->save) ) {
			if ( $request->publishDate ) {
				$publish = Carbon::parse( $request->publishDate )->format("Y-m-d H:i:s");
				$status = 1;
			}
			else {
				$status = 0;
				$publish = $request->publishDate ? Carbon::parse( $request->publishDate )->format("Y-m-d H:i:s") : null;
			}
		}
		elseif( $request->publish == 1 ) {
			$status = 1;
			$publish = date( "Y-m-d H:i:s", (time() - 10) );
		}
		else {
			$status = 0;
			$publish = $publish = $request->publishDate ? Carbon::parse( $request->publishDate )->format("Y-m-d H:i:s") : null;
		}

		$bundle->title = $request->title;
		$bundle->subtitle = $request->subtitle;
		$bundle->summary = $request->summary;
		$bundle->description = $request->description;
		$bundle->publish_at = $publish;
		$bundle->status = $status ;
		$bundle->slug = Str::slug($request->title, "-");
		$bundle->save();

		return redirect( "/dashboard/bundle/$bundle->slug" );
    }


    public function destroy(Bundle $bundle)
    {
        //
	}

	public function softDelete(Bundle $bundle)
    {
		$bundle->delete();

		return redirect("/dashboard/bundles");

    }
}
