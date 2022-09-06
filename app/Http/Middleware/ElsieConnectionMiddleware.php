<?php

namespace App\Http\Middleware;

use App\Actions\ElsieServiceStateAction;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ElsieConnectionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        return ElsieServiceStateAction::make()->handle() ? $next($request) : back(301)->with('message', __('Service unavailable'));
    }
}
