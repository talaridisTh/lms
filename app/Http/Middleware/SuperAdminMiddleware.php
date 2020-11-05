<?php

namespace App\Http\Middleware;

use App\Role;
use App\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuperAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        $user = Auth::user();

        $superAdminIds = Role::whereId(1)->first()->users->map(function($superAdmin){
            return $superAdmin->id;
        });

        if ($user->hasRole('admin')) {
            User::whereNotIn('id', $superAdminIds)->get();

        } else {

            $users = User::all();
        }

        return $next($request);
    }
}
