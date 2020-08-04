<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller {


    public function index()
    {

        return view('admin.users.usersMain');
    }

    public function create()
    {

        return view("admin.users.userCreate");
    }

    public function store(UserCreateRequest $request)
    {
        //
        $user = new User();
        $data = collect($request)->except('password', "avatar")->all();
        $data['password'] = Hash::make("password");
        $data['active'] = 1;
        if ($files = $request->file('avatar'))
        {
            $destinationPath = 'public/image/users';
            $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $profileImage);
            $data['avatar'] = $profileImage;
        } else
        {
            $data["avatar"] = "https://robohash.org/default.png?set=set4";
        }
        $user->create($data)->assignRole($request->role);

        return redirect(route("user.index"));
    }

    public function show(User $user)
    {
        $userIs = User::userIs($user);
        $userCourses = $user->courses()->get();

        $allMaterials = User::findMaterials($user->id);

        $InstructorCourses = User::getMaterialsInstructor($user->id);

//        $InstructorCourses = User::getCountStudent($user->id);







        return view('admin.users.userProfile', compact("user", "allMaterials", "userCourses", "userIs","InstructorCourses"));
    }

    public function update(Request $request, User $user)
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

        return redirect()->back();
    }

    public function destroy(User $user)
    {

        $user->delete();

        return redirect(route('user.index'));
    }

    public function changeStatus(Request $request)
    {
        $user = User::find($request->id);
        $user->active = $request->active;
        $user->save();

        return response()->json(['success'=>'Status change successfully.']);
    }

}
