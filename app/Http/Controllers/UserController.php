<?php

namespace App\Http\Controllers;


use App\DataTables\UsersDataTable;
use App\Http\Requests\UserCreateRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
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

    public function show(User $user,UsersDataTable $dataTable)
    {


        $userIs = User::userIs($user);
        $userCourses = $user->courses()->get();
        $allMaterials = User::findMaterials($user->id);

        return view('admin.users.userProfile', compact("user", "allMaterials", "userCourses", "userIs"));


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
            $destinationPath = public_path("images") . '/student';
            $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $profileImage);
            $data['avatar'] = $profileImage;
        } else
        {
            $data["avatar"] = "https://robohash.org/default.png?set=set4";
        }
        $user->create($data)->assignRole($request->role);

        return redirect(route("user.index"))->with('create', 'Ο ' . $data["first_name"] . " " . $data["last_name"] . ' δημιουργήθηκε');
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

        return redirect()->back()->with('update', 'Ο ' . $user->fullName . ' ενημερώθηκε');
    }

    public function destroy(User $user)
    {

        $user->delete();

        return redirect(route('user.index'));
    }

    public function createLink()
    {


        $tempUrl  =  URL::temporarySignedRoute('link', now()->addMinutes(480));



       return redirect()->back()->with("link",$tempUrl );
    }



}
