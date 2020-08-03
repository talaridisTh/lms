<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        $roles = [];
        $rolesName = Role::all();
        foreach ($users as $user)
        {
            array_push($roles, $user->getRoleNames()->first());
        }


        return view('admin/users/usersMain', compact("roles", "users", "rolesName"));
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
        $rolesName = Role::all();

        $userIs = User::userIs($user);

        $userCourses = $user->courses()->get();

        $allMaterials =User::findMaterials($user->id);




        return view('admin.users.userProfile', compact("user", "rolesName","allMaterials","userCourses","userIs"));
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

}
