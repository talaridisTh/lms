<?php

namespace App\Http\Controllers\Ajax;

use App\Course;
use App\DataTables\AddCoursesDataTable;
use App\DataTables\CoursesInsideUsersDataTable;
use App\DataTables\UserProfileDataTable;
use App\DataTables\UsersDataTable;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController {

    public function index(UsersDataTable $dataTable, Request $request)
    {

        return $dataTable->render('users.index');
    }

    public function show(UserProfileDataTable $dataTable)
    {

        return $dataTable->render('users.profile');
    }

    public function addCourseModal(AddCoursesDataTable $dataTable)
    {

        return $dataTable->render('users.addCourses');
    }

    public function coursesInsideUsers(CoursesInsideUsersDataTable $dataTable)
    {

        return $dataTable->render('users.coursesInsideUsers');
    }

    public function changeStatus(Request $request)
    {
        $user = User::find($request->id);
        $user->status = $request->status;
        $user->save();

        return response()->json(['success' => 'Status change successfully.']);
    }

    public function changeStatusMultiple(Request $request)
    {

        foreach ($request->user_id as $user_id)
        {
            $user = User::findOrFail($user_id);
            if($request->status=="on"){
                $user->status = true;
                $user->save();
            }
            else{
                $user->status = false;
                $user->save();
            }
        }

        return response()->json(['success' => 'Status change successfully.']);
    }

    public function addCourses(Request $request)
    {


        $user = User::find($request->user_id);
        $user->courses()->attach($request->course_id);

        return response()->json(['success' => 'Status change successfully.']);
    }

    public function addCoursesMultipleUsers(Request $request)
    {


        $courses = Course::findOrFail($request->course_id);
        foreach ($courses as $course){

            $course->users()->syncWithoutDetaching($request->user_id);
        }

        return response()->json(['success' => 'Status change successfully.']);
    }

    public function destroy(Request $request)
    {

//
        $user = User::find($request->user_id);
        $user->courses()->detach($request->course_id);

        return response()->json(['success' => 'Status change successfully.']);
    }

    public function destroyMultipleCourses(Request $request)
    {
        $user = User::find($request->user_id);
        $user->courses()->detach($request->course_id);

        return response()->json(['success' => 'Status change successfully.']);
    }

    public function destroyMultipleUsers(Request $request)
    {

        User::whereIn('id', $request->user_id)->delete();
    }

}
