<?php

namespace App\Http\Controllers;

use App\Course;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

//

        return $test = DB::table("courses")
            ->join("course_material","courses.id","=","course_material.course_id")
            ->join("materials","course_material.material_id","=","materials.id")
            ->join("material_user","material_user.material_id","=","materials.id")
            ->join("users","material_user.user_id","=","users.id")
            ->where("users.id",80)
            ->where("courses.id",10)
            ->select("courses.id")
            ->get();








        return view('home');
    }
}
