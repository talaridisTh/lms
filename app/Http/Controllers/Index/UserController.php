<?php

namespace App\Http\Controllers\Index;

use App\Models\Course;
use App\DataTables\HistoryCourseDatatable;
use App\DataTables\HistoryMaterialDatatable;
use App\DataTables\WatchlistCourseDatatable;
use App\DataTables\WatchlistMaterialDatatable;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\MediaUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UserController extends Controller {

    use MediaUploader;

    public function index()
    {

        $user = auth()->user();
        $socialLinks = [$user->facebook_link, $user->instagram_link, $user->linkedin_link, $user->youtube_link];

        return view("index.users.user-edit", [
            "user" => $user,
            "courses" => $user->courses,
            "existSocials" => $this->arrayIsNotEmpty($socialLinks),
            "sumMaterials" => $this->getMaterial($user)["countMaterials"],
            "sumCourses" => $user->courses()->count(),
            "sumBundles" => $user->bundles()->count()
        ]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $socialLinks = [$user->facebook_link, $user->instagram_link, $user->linkedin_link, $user->youtube_link];
        $validator = Validator::make($request->all(), [
            "name" => "required|min:2|max:20",
            "last" => "required|min:2|max:20",
            'phone' => 'required|numeric',
            'email' => 'unique:users,email,' . auth()->id(),
            'password' => 'confirmed',
            "profil" => "min:5|max:100",
        ]);
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator);
        }
        auth()->user()->update([
            "first_name" => $request->name,
            "last_name" => $request->last,
            "email" => $request->email,
            "phone" => $request->phone,
            "profil" => $request->profil,
            "facebook_link" => $request->facebook,
            "instagram_link" => $request->instagram,
            "linkedin_link" => $request->linkedin,
            "youtube_link" => $request->youtube
        ]);
//            if ($request->password)
//            {
//
//            }
        return view("index.users.user-edit", [
            "user" => $user,
            "courses" => $user->courses,
            "existSocials" => $this->arrayIsNotEmpty($socialLinks),
            "sumMaterials" => $this->getMaterial($user)["countMaterials"],
            "sumCourses" => $user->courses()->count(),
            "sumBundles" => $user->bundles()->count()
        ]);
    }

    public function uploadAvatar(Request $request)
    {

        $cover = $this->storeImage($request->file);

        auth()->user()->update([
            "avatar"=>$cover->rel_path
        ]);

        return view("index.users.user-cover",["user"=>auth()->user()]);

    }

    private function arrayIsNotEmpty($arr)
    {
        if (is_array($arr))
        {
            foreach ($arr as $key => $value)
            {
                if (!empty($value) || $value != null || $value != "")
                {
                    return true;
                    break;
                }
            }

            return false;
        }
    }

    private function getMaterial($user)
    {
        $lessons = $user->courses()->with("activeMaterials")->get()->pluck("activeMaterials")->flatten()->whereIn("type", ["Lesson", "Video", "Link", "PDF"])->unique("slug");
        $sections = $user->courses()->wherehas("activeMaterials")->get()->pluck("activeMaterials")->flatten()->where("type", "Section")->unique("slug");
        $isSectionExist = $sections->map(function ($section) {
            if ($section->activeChapters->isNotEmpty())
            {
                return $section->activeChapters;
            }
        })->reject(function ($name) {
            return empty($name);
        });

        return ["lessons" => $lessons, "section" => $isSectionExist, "countMaterials" => count($lessons) + count($isSectionExist)];
    }

}
