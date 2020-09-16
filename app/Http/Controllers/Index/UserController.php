<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use App\Mail\NewUserNotification;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller {

    //
    public function index()
    {

        $announcements = auth()->user()->courses->map(function ($course) {
            return $course->materials->where("type", 'Announcement');
        })->flatten(1);

        return view("index.users.user-profile", compact('announcements'));
    }

    public function update(Request $request, User $user)
    {

        $user->update($request->except('password', 'password_confirmation', "status"));
        $data = collect($request)->all();
        $user->save();
        if ($request->password)
        {
            $user->update(['password_encrypt' => Crypt::encryptString($request->password)]);
            $user->update(['password' => Hash::make(request("password"))]);
        }

        return redirect()->back()->with('update', 'Ο ' . $user->fullName . ' ενημερώθηκε');
    }

    public function ShowAnnouncements(User $announcements)
    {

        return view('index.users.user-announcement', [
            'announcements' => $announcements = auth()->user()->courses->map(function ($course) {
                return $course->materials->where("type", 'Announcement');
            })->flatten(1)]);
    }

    public function watchlist(User $user)
    {

        $watchlistCourses = $user->watchlistCourse()->get();
        $watchlistMaterials = $user->watchlistMaterial()->get();

        return view("index.users.user-watchlist",compact("watchlistCourses","watchlistMaterials"));

    }

}
