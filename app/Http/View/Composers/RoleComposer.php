<?php

namespace App\Http\View\Composers;

use App\User;
use Spatie\Permission\Models\Role;
use Illuminate\View\View;

class RoleComposer {

    public function compose(View $view)
    {
        $view->with("rolesName",Role::all());
        $view->with("users", $users = User::all());
    }

}
