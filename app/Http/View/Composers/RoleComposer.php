<?php

namespace App\Http\View\Composers;

use App\Models\Course;
use Spatie\Permission\Models\Role;
use Illuminate\View\View;

class RoleComposer {

    public function compose(View $view)
    {
        $view->with("rolesName",Role::all()->except([6,8]));

//        $view->with("users", $users = User::whereHas("courses")->get());
//        $view->with("users", $users = User::all());
        $view->with("courses", $courses = Course::orderBy("id",'desc')->get());
    }

}
