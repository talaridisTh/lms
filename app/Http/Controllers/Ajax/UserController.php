<?php

namespace App\Http\Controllers\Ajax;

use App\Models\Course;
use App\DataTables\Users\CoursesDataTable;
use App\DataTables\Users\HomeworksDataTable as UserHomeworksDatatable;
use App\DataTables\Users\UserCoursesDataTable;
use App\DataTables\Users\UsersDataTable;
use App\Models\Media;
use App\Models\User;
use App\Notifications\SentPasswordNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserController {

    public function index(UsersDataTable $dataTable, Request $request)
    {

        return $dataTable->render('users.index');
    }

    public function show(UserCoursesDataTable $dataTable)
    {

        return $dataTable->render('users.profile');
    }

    public function addCourseModal(CoursesDataTable $dataTable)
    {

        return $dataTable->render('users.addCourses');
	}
	
	public function useHomeworksDatatable(UserHomeworksDatatable $datatable) {
		
		return $datatable->render('users.homeworks');
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

    public function addCourses(Request $request, User $user)
    {

        foreach ($request->ids as $id)
        {
            $user->courses()->attach($id);
        }
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
        $user = User::find($request->user_id);
        $user->courses()->detach($request->course_id);
        $user->watchlistCourse()->detach($request->course_id);

        return response()->json(['success' => 'Status change successfully.']);
    }

    public function destroyMultipleUsers(Request $request)
    {

        User::whereIn('id', $request->user_id)->delete();
    }

    public function showPassword(Request $request, User $user)
    {

        if (!Hash::check($request->password, auth()->user()->password))
        {
            return response()->json(['error' => 'Λάθος κωδικός.'], 401);
        }

        return response()->json([
            "password" => Crypt::decryptString($user->password_encrypt)
        ]);
    }

    public function avatarUpload(Request $request)
    {

        $user = User::findorFail($request->userId);
        $date = date('m.Y');
        $image = $request->file;
        if ($image->isValid())
        {
            $temp = explode(".", $image->getClientOriginalName());
            $name = implode("-", array_diff($temp, [$image->getClientOriginalExtension()]));
            $name = Str::slug($name, "-");
            $name .= "." . $image->getClientOriginalExtension();
            $media = new Media;
            $media->original_name = $image->getClientOriginalName();
            $media->name = $name;
            $media->rel_path = "storage/$date/images/" . $name;
            $media->ext = $image->getClientOriginalExtension();
            $media->file_info = $image->getClientMimeType();
            $media->size = $image->getSize();
            $media->save();
            $image->storeAs("public/$date/images", $name);
        }

        return response()->json($request->file);
    }

    public function resetAvatar(User $user)
    {
        $user->avatar = "/images/avatar-placeholder.png";
        $user->save();
    }

    public function sentInfo(User $user)
    {
        // $password = Crypt::decryptString($user->password_encrypt);
        // $message = "Ο κωδικός σας είναι: $password";
        // Mail::raw($message, function ($message) use ($user) {
        //     $message->to($user->email)
        //         ->subject("Υδρόγειος Education, ανάκτηση κωδικού");
		// });
		
		$user->notify(new SentPasswordNotification);
    }

    public function confirmPassword(Request $request)
    {

        $isValid = Hash::check($request->password, auth()->user()->password);
        if ($isValid)
        {
            return response('Authorized', 200);
        }

        return response('Λάθος κωδικός...', 401);
    }

    public function deleteUser(User $user)
    {

        $user->delete();
    }

    public function removeCourses(Request $request, User $user)
    {

        foreach ($request->ids as $id)
        {
            $user->courses()->detach($id);
        }
    }

}
