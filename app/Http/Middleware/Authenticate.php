<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) 
        {
                if($request->routeIs('admin.*'))
                {
                    return route('admin.login');
                }
                elseif($request->routeIs('teacher.*'))
                {
                    return route('teacher.login');
                }
                elseif($request->routeIs('student.*'))
                {
                    return route('student.login');
                }
                elseif($request->routeIs('super.*'))
                {
                    return route('super.login');
                }
                //  return route('student.login');
          
            // return route('login');
        }
    }
}
