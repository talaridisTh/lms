<?php

namespace App\Http\Controllers;

use App\DataTables\UsersDataTable;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Mail\NewUserNotification;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use PhpParser\Node\Stmt\DeclareDeclare;
use Spatie\Activitylog\Models\Activity;

class UserController extends Controller {

    public function index()
    {
        $activeCourses = User::courseWhereActive();

        return view('admin.users.usersMain', compact("activeCourses"));
    }

    public function create()
    {

        $userCourses = [];
        return view('admin.users.userProfile',compact("userCourses"));
    }

    public function show(User $user)
    {

        $userIs = User::userIs($user);
        $userCourses = $user->courses()->get();
        $allMaterials = User::findMaterials($user->id);
        $activities = Activity::where("causer_id", $user->id)->get();

        return view('admin.users.userProfile', compact("user", "allMaterials", "userCourses", "userIs", "activities"));
    }

    public function store(Request $request)
    {
        //



        $user = new User();
        $data = collect($request)->except( "sendMail", "roles","password_confirmation","media","media_original_name")->all();
        $data['password'] = Hash::make("password");
        $data["slug"] = Str::slug($request->first_name, "-");
        if ($files = $request->file('avatar'))
        {
            $destinationPath = public_path("images") . '/student';
            $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $profileImage);
            $data['avatar'] = $profileImage;
        } else
        {
            $data["avatar"] = "https://robohash.org/default.png?set=set4";
        }
        if ($request->status)
        {
            $data["status"] = 1;
        } else
        {
            $data["status"] = 0;
        }

        if ($request->sendMail)
        {
            Mail::to(auth()->user()->email)->send(new NewUserNotification($user->fullName));
        }
        if ($request->password)
        {

            $data["password_encrypt"] =  Crypt::encryptString($request->password);
            $data["password"] =  Hash::make(request("password"));

        }
      $currentUser =   $user->create($data)->assignRole($request->roles);

        foreach ($request->input('media', []) as $index => $file) {
            //Media Library should now attach file previously uploaded by Dropzone (prior to the post form being submitted) to the post
            $currentUser->addMedia(storage_path("app/" . $file))
                ->usingName($request->input('media_original_name', [])[$index]) //get the media original name at the same index as the media item
                ->toMediaCollection();
        }


        return redirect(route("user.index"))->with('create', 'Ο ' . $data["first_name"] . " " . $data["last_name"] . ' δημιουργήθηκε');
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        //

        $user->update($request->except('roles', 'password', 'avatar', 'password_confirmation', "status", "sendMail"));
        $data = collect($request)->except( "sendMail")->all();
        $user->syncRoles($request->roles);
        if ($files = $request->file('avatar'))
        {
            $destinationPath = 'public/image/users';
            $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $profileImage);
            $data['avatar'] = $profileImage;
        }
            $user->update(['status' => isset($request->status)  ? 1 : 0]);

        if ($request->sendMail)
        {

            Mail::to(auth()->user()->email)->send(new NewUserNotification($user->fullName, $request->password));
        }
        if ($request->password)
        {



            $user->update(['password_encrypt' =>  Crypt::encryptString($request->password)]);
            $user->update(['password' =>  Hash::make(request("password"))]);



        }

        return redirect()->back()->with('update', 'Ο ' . $user->fullName . ' ενημερώθηκε');
    }

    public function destroy(User $user)
    {

        $user->delete();

        return redirect(route('user.index'));
    }

    public function userCourses(User $user)
    {

        return view('courses/courses')->withUser($user);
    }

}
