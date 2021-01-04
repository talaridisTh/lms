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

        $user = auth()->user();
        $socialLinks = [$user->facebook_link, $user->instagram_link, $user->linkedin_link, $user->youtube_link];
        return view("index.users.user-edit", [
            "user" => $user,
            "courses" => auth()->user()->courses,
            "existSocials"=>$this->arrayIsNotEmpty($socialLinks),
            "sumMaterials"=>$this->getMaterial($user)["countMaterials"],
            "sumCourses"=>$user->courses()->count(),
            "sumBundles"=>$user->bundles()->count()
        ]);
    }

    private function arrayIsNotEmpty($arr)
    {
            if(is_array($arr)){
                foreach($arr as $key => $value){
                    if(!empty($value) || $value != NULL || $value != ""){
                        return true;
                        break;
                    }
                }
                return false;
            }
    }

    private function getMaterial($user )
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

        return ["lessons" => $lessons, "section" => $isSectionExist,"countMaterials"=>count($lessons)+count($isSectionExist)];
    }

}
