<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Media;
use App\Models\User;
use App\Notifications\ChangedPasswordNotification;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Activitylog\Models\Activity;
use App\Notifications\NewUserNotification;

class UserController extends Controller {

    public function index()
    {
        $activeCourses = User::courseWhereActive();

        return view('admin.users.usersMain', compact("activeCourses"));
    }

    public function create()
    {
        return view('admin.users.userCreate');
    }

    public function show(User $user)
    {
        //
    }

    public function store(UserCreateRequest $request)
    {
        $user = new User();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->avatar = "/images/avatar-placeholder.png";
        $user->email = $request->email;
        $user->slug = Str::slug($request->email);
        $user->phone = $request->phone;
        $user->password = Hash::make($request->password);
        $user->password_encrypt = Crypt::encryptString($request->password);
        $user->status = isset($request->status) ? 1 : 0;
        $user->profil = $request->profil;
        $user->facebook_link = $request->facebook_link;
        $user->instagram_link = $request->instagram_link;
        $user->youtube_link = $request->youtube_link;
        $user->linkedin_link = $request->linkedin_link;
        $user->save();
        $user->assignRole($request->role);
		
		$user->notify(new NewUserNotification);

        return redirect("/dashboard/users/$user->slug");
    }

    public function edit(User $user)
    {
        $data = [
            "user" => $user,
            "userRole" => $user->getRoleNames()->first(),
            "media" => Media::where("type", 0)->paginate(18),
			"activities" => Activity::where("causer_id", $user->id)
				->orderBy("created_at", "desc")->limit(5)->get(),
        ];

        return view('admin.users.userProfile')->with($data);
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->slug = Str::slug($request->email);
        $user->phone = $request->phone;
        $user->profil = $request->profil;
        $user->facebook_link = $request->facebook_link;
        $user->instagram_link = $request->instagram_link;
        $user->youtube_link = $request->youtube_link;
		$user->linkedin_link = $request->linkedin_link;
		
        if (!is_null($request->password)) {

            $user->password_encrypt = Crypt::encryptString($request->password);
			$user->password = Hash::make($request->password);
			
			$user->notify(new ChangedPasswordNotification);
		}
		
		$user->save();

        $user->syncRoles($request->role);

        return redirect("/dashboard/users/$user->slug");
    }

    public function destroy(User $user)
    {

        $user->delete();

        return redirect(route('user.index'));
    }

    public function userCourses(User $user)
    {

        return view('courses/courses')->with(["user" => $user]);
    }

}
