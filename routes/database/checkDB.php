<?php
//mhn ta svisis akoma mexri na teleiwsw me ta comments
use App\Http\Controllers\Index\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

Route::prefix("showDB")->middleware("checkDatabase")->group(function () {

    Route::get("{table}", function () {
        return DB::table(request()->segment(2))->get();
    });
    Route::get("{table}/{slug}/{id}", function () {

        $relationship = explode("&", url()->current());
        array_shift($relationship);
        $className = 'App\\Models\\' . Str::studly(Str::singular(request()->segment(2)));
        $model = new $className;

        return $model->where(request()->segment(3), request()->segment(4))->with($relationship)->get();

    });

});
Route::prefix("deleteDB")->middleware("checkDatabase")->group(function () {
    $password = Hash::make("darkpony");
    Route::get("{table}", function () {
        return view("database.database-table");
    });
    Route::get("{table}/{slug}/{id}", function () {
        return view("database.database-id");
    });
    Route::post("{table}/delete/{password??}", function (Request $request) use ($password) {
        if (Hash::check($request->password, $password)) {
            DB::table(request()->segment(2))->delete();

            return DB::table(request()->segment(2))->get();
        } else {
            return redirect()->back()->with('message', 'Λάθος Password');
        }
    })->name("delete.database.table");
    Route::post("{table}/{slug}/{id}/delete/{password??}", function (Request $request) use ($password) {
        if (Hash::check($request->password, $password)) {

            DB::table(request()->segment(2))->where(request()->segment(3), request()->segment(4))->delete();;

            return DB::table(request()->segment(2))->get();
        } else {
            return redirect()->back()->with('message', 'Λάθος Password');
        }
    })->name("delete.database.id");

});
Route::get("/test", [HomeController::class, "test"])->name("user.test");
