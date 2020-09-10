<?php

namespace App\Http\Controllers;

use App\Media;
use App\User;
use Illuminate\Http\Request;

class MediaController extends Controller
{

    public function index()
    {

        // $allMedia = Media::all();
//        $allMedia = User::find(100)->getMedia();
        // dd($allMedia);



        return view("admin.media.mediaIndex");

    }
    public function customStore(Request $request)
    {
        //



        $path = $request->file('file')->store('uploads');
        $file = $request->file('file');

        return response()->json([
            'name' => $path,
            'original_name' => $file->getClientOriginalName(),
        ]);


    }


}
