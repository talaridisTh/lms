<?php

namespace App\Http\Controllers\Index;

use App\Models\Course;
use App\DataTables\HistoryCourseDatatable;
use App\DataTables\HistoryMaterialDatatable;
use App\DataTables\WatchlistCourseDatatable;
use App\DataTables\WatchlistMaterialDatatable;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller {

    //
    public function watchlistDatatable(WatchlistCourseDatatable $datatable)
    {
        return $datatable->render('watchlist.datatable');

    }
    public function watchlistMaterialDatatable(WatchlistMaterialDatatable $datatable)
    {
        return $datatable->render('watchlistMaterial.datatable');

    }
    public function historyCourseDatatable(HistoryCourseDatatable $datatable)
    {
        return $datatable->render('historyCourse.datatable');

    }
    public function historyMaterialDatatable(HistoryMaterialDatatable $datatable)
    {
        return $datatable->render('historyMaterial.datatable');

    }



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

    public function watchlist()
    {

        return view("index.users.user-watchlist");

    }

    public function history()
    {


        $data = auth()->user()->witchlist;

        $courseIds = $data->map(function ($course){
            return $course->pivot->course_id;
        });

        $courses = $courseIds->unique()->map(function ($course){
            return Course::findOrFaIL($course);
        });


        return view("index.users.user-history",compact("courses"));

    }

}
