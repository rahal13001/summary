<?php

namespace App\Http\Middleware;

use App\Models\Report;
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
    public function handle(Report $report, Request $request, Closure $next)
    {

        dd($report->id);

        $rep_user_id = $report->user_id;
        $user_id = Auth::user()->id;
         
        $ikutan = $report->follower->find($user_id);
        if ($ikutan == null || $rep_user_id == $user_id) {
            return abort(403, 'Ini Bukan Milikmu, Kamu Mau Apa ?');
        } else {
            return $next($request);
        }
    }
}
