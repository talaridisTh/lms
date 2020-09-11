<?php

namespace App\Http\Controllers\Ajax;

use App\Course;
use App\DataTables\AddCoursesDataTable;
use App\DataTables\CoursesInsideUsersDataTable;
use App\DataTables\UserProfileDataTable;
use App\DataTables\UsersDataTable;
use App\Media;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
            if ($request->status == "on")
            {
                $user->status = true;
                $user->save();
            } else
            {
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
        foreach ($courses as $course)
        {

            $course->users()->syncWithoutDetaching($request->user_id);
        }

        return response()->json(['success' => 'Status change successfully.']);
    }

    public function AddMultipleUserCourse(Request $request)
    {

        $courses = Course::findOrFail($request->course_id);
        $courses->users()->syncWithoutDetaching($request->user_id);

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

    public function showPassword(Request $request)
    {

        if (Hash::check($request->password, auth()->user()->password))
        {
            return response()->json(['success' => 'successfully.']);
        }
    }

    public function avatarUpload(Request $request)
    {


        $user = User::findorFail($request->userId);

        $date = date('m.Y');
        $image=  $request->file;

        if ( $image->isValid() )
        {
            $name = $image->getClientOriginalName();
            $media = new Media();
            $media->name = $name;
            $media->slug = Str::slug($name . "-" . rand(1, 100), "-");
            $media->rel_path = "storage/users/images/$date/" . $image->getClientOriginalName();
            $media->ext = $image->getClientOriginalExtension();
            $media->file_info = $image->getClientMimeType();
            $media->size = $image->getSize();
            $media->save();
            $user->media()->detach();
            $user->media()->attach($media->id, ["usage" => 0]);
            $image->storeAs("public/users/images/$date", $name);
        }


    }

}
