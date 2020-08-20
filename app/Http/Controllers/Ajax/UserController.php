<?php

namespace App\Http\Controllers\Ajax;

use App\Course;
use App\DataTables\AddCoursesDataTable;
use App\DataTables\UserProfileDataTable;
use App\DataTables\UsersDataTable;
use App\User;
use Illuminate\Http\Request;

class UserController {

    public function index(UsersDataTable $dataTable)
    {

        return $dataTable->render('users.index');
    }

    public function show(UserProfileDataTable $dataTable)
    {

        return $dataTable->render('users.profile');
    }

    public function changeStatus(Request $request)
    {
        $user = User::find($request->id);
        $user->active = $request->active;
        $user->save();

        return response()->json(['success' => 'Status change successfully.']);
    }

    public function addCourseModal(AddCoursesDataTable $dataTable)
    {

        return $dataTable->render('users.addCourses');
    }

    public function addCourses(Request $request)
    {

        $coursess= [];
        foreach ($request->course_id as  $course){
            array_push($coursess,  Course::findOrFail($course));

        }

        $user = User::find($request->user_id);
        $user->courses()->attach($request->course_id);

        return response()->json($coursess);
    }

    public function addCoursesMultipleUsers(Request $request)
    {


        $course = Course::findOrFail($request->course_id);



        $course->users()->syncWithoutDetaching($request->user_id);

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

        dd($request->all());

    }

}
