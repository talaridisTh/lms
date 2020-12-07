<?php

namespace App\Http\Middleware;

use App\Models\Role;
use App\Models\User;
use Closure;
use Illuminate\Support\Facades\Auth;
Use Illuminate\Http\Request;

class RoleMiddleware {

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
		$allowed = ["admin", "super-admin"];
		$roles = Auth::user()->getRoleNames();
		
		foreach ($roles as $role) {
			if (in_array($role, $allowed)) {
				return $next($request);
			}
		}
		// dd(Auth::user()->getRoleNames());

		

        // if ($role[0] == "admin" || $role[0] == "super-admin")
        // {
        //     return $next($request);
        // }

        return redirect()->to('/');
    }

}
