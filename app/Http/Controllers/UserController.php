<?php

namespace App\Http\Controllers;


use App\DataTables\UsersDataTable;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Mail\NewUserNotification;
use App\User;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Str;

use Spatie\Activitylog\Models\Activity;


class UserController extends Controller {

    public function index()
    {
        $activeCourses = User::courseWhereActive();

        return view('admin.users.usersMain',compact("activeCourses"));
    }

    public function create()
    {

        return view("admin.users.userCreate");
    }

    public function show(User $user, UsersDataTable $dataTable)
    {

        $userIs = User::userIs($user);
        $userCourses = $user->courses()->get();
        $allMaterials = User::findMaterials($user->id);
        $activities  = Activity::where("causer_id",$user->id)->get();

        return view('admin.users.userProfile', compact("user", "allMaterials", "userCourses", "userIs","activities"));
    }

    public function store(UserCreateRequest $request)
    {
        //

        $user = new User();
        $data = collect($request)->except('password', "avatar","sendMail","roles")->all();
        $data['password'] = Hash::make("password");
        $data["slug"]= Str::slug($request->first_name,"-");


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
        if($request->status){


        }
        if($request->password){
            $data["password"] =  bcrypt(request("password"));
        }
        if($request->status){
            $data["status"] =  1;
        }else{
            $data["status"] =  0;
        }


        dd($data);
        $user->create($data)->assignRole($request->roles);


        if($request->sendMail){
            $mail = ['message' => 'This is a test!'];

            Mail::to('john@example.com')->send(new NewUserNotification($mail));
        }


        return redirect(route("user.index"))->with('create', 'Ο ' . $data["first_name"] . " " . $data["last_name"] . ' δημιουργήθηκε');
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        //
        $data = collect($request)->except("avatar")->all();
        $user->update($data);
        $user->syncRoles($request->role);
        if ($files = $request->file('avatar'))
        {
            $destinationPath = 'public/image/users';
            $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $profileImage);
            $data['avatar'] = $profileImage;
        }

        return redirect()->back()->with('update', 'Ο ' . $user->fullName . ' ενημερώθηκε');
    }

    public function destroy(User $user)
    {

        $user->delete();

        return redirect(route('user.index'));
    }

	public function userCourses( User $user ) {



		return view('courses/courses')->withUser( $user );

	}



}
