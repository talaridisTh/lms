<?php

namespace App\Http\Middleware;

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
		$role = Auth::user()->getRoleNames();
		
		if ( $role[0] == "admin" || $role[0] == "instructor" ) {
			return $next($request);
		}

		// return view('welcome')->with('user', Auth::user());
		return redirect()->to('/');
    }
}
