<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifyCourses
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

        if (auth()->user()->getRoleNames()[0]=="admin"){
            return $next($request);

        }

        $courseId = $request->route("course")->id;



       $user = auth()->user()->courses->whereIn("id",$courseId);


        if (count($user)>0 ) {
            return $next($request);
        }
        return redirect(route("home"));
    }
}
