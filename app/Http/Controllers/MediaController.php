<?php

namespace App\Http\Controllers;

use App\Media;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MediaController extends Controller
{

    public function index()
    {

         $allMedia = Media::all();





        return view("admin.media.mediaIndex",compact('allMedia'));

    }



}
