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

        $test = Course::find(1)->with('materials.users')->get();

        return  $test[0]["materials"]->first();

        return view('home');
    }
}
