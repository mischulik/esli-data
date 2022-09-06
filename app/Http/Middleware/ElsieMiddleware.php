<?php

namespace App\Http\Middleware;

use App\Actions\Auth\ElsieLoginAction;
use App\Models\ElsieCredentials;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ElsieMiddleware
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
        $credentials = optional(ElsieCredentials::query()->where([
            'user_id' => auth()->id(),
        ])->whereNotNull(['email', 'passwd', 'cookie'])->first() ?? null, function (ElsieCredentials $credentials) {
            if (now()->subDays(7)->greaterThanOrEqualTo($credentials->updated_at)) {
                ElsieLoginAction::make()->handle($credentials);
            }
            return $credentials;
        }) ?? null;
        return $credentials ? $next($request) : redirect('login');
    }
}
