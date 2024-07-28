<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Log;

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
        if (! $request->expectsJson() && ! $request->isMethod('PUT')) {
            return route('login');
        }
    }

    protected function authenticate($request, array $guards)
    {
        Log::info('Authenticating request...', ['guards' => $guards]);

        if ($this->auth->guard('api')->check()) {
            Log::info('User is authenticated.');
            return $this->auth->shouldUse('api');
        }

        Log::warning('User is not authenticated.', ['request' => $request->all()]);
        $this->unauthenticated($request, $guards);
    }
}