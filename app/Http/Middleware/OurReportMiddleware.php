<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class OurReportMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
            // $roles = Role::find(Auth::user()->id);

            // dd(Auth::user()->roles);
            $aut = Auth::user()->roles;
            foreach ($aut as $role1) {
                
                    if ($role1->id !== 1 || $role1->id !== 2) {

                        $rep = $request->report->user_id;
                        $user = Auth::user()->id;       
                        $cek = $request->report->follower->find($user);
                        
                        if (is_null($cek) || $user !== $rep) {
                            return abort(403, 'Balik Sudah, Ini Bukan Ko Punya -_-');
                        } else {
                            return $next($request);
                        }
                    }
                    return $next($request);

            }
            
        

    }
    
}
