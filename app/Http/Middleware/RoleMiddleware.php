<?php

namespace App\Http\Middleware;

use App\Role;
use App\User;
use Closure;

use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $urlEnd = array_slice(explode('/', url()->current()), -1)[0];
        $user = User::where("slug",$urlEnd)->firstOrFail();

        if($user->getRoleNames()[0]=="guest"){
            Auth::login($user);
            return $next($request);
        }


		$role = $request->user()->getRoleNames();


		if ( $role[0] == "admin" || $role[0] == "instructor" ) {
			return $next($request);
		}

		return redirect()->to('/');
    }
}
