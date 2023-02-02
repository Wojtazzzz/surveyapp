<?php

declare (strict_types = 1);

namespace App\Http\Middleware;

use App\Enums\SurveyStatus;
use Closure;
use Illuminate\Http\Request;

class WithoutTestingSurveys
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
        abort_if($request->survey->status === SurveyStatus::TESTING, 404);

        return $next($request);
    }
}
