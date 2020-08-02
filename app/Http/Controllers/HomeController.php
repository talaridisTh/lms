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
        $materials = User::whereId(5)->with('courses.materials')->first();
//        dd($materials->courses);
//        foreach ($materials->courses as $mat){
//            echo $mat;
//        }
//
//         return !$materials->courses->first() == [] ? $materials->courses->first()->materials: "";



        return view('home');
    }
}
