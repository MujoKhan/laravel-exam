<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {

                if($guard === 'admin')
                {
                    return redirect()->route('admin.home');
                }
                elseif($guard === 'super')
                {
                    return redirect()->route('super.home');
                }
                elseif($guard === 'teacher')
                {
                    return redirect()->route('teacher.home');
                }
                elseif($guard === 'student')
                {
                    // if($request->routeIs('user.*'))
                    // {
                    //     if(Auth::guard('emp')->user()->post == "HR")
                    //     {
                    //         return redirect()->route('user.hr.home');                       
                    //     }
                    //     elseif(Auth::guard('emp')->user()->post == "Inter Viewer")
                    //     {
                    //         return redirect()->route('user.interviewer.home');                       
                    //     }
                    //     if(Auth::guard('emp')->user()->post == "Data Admin")
                    //     {
                    //         return redirect()->route('user.dataadmin.home');                       
                    //     }
                    // }
                    return redirect()->route('student.home');   
                
                }
                // return redirect()->route('user.home');
                // return redirect(RouteServiceProvider::HOME);
            }
        }

        return $next($request);
    }
}
