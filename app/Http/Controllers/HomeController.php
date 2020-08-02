<?php

namespace App\Http\Controllers;

use App\Course;
use App\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;


class HomeController extends Controller
{

    /**
     *
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()

    {
        $user = User::findOrFail(6);

//        $test= Course::findOrFail(3);
//        dd($test);


//
//        $test = User::whereId(6)->with('courses.materials')->first();
//
//        return $test->courses->first()->materials;
////        dd($user->has('courses')->get());



        return view('home');
    }
}
