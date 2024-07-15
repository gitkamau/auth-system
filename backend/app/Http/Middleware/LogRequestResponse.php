<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class LogRequestResponse
{
    public function handle($request, Closure $next)
    {
        Log::info('Request:', $request->all());
        $response = $next($request);
        Log::info('Response:', $response->getContent());
        return $response;
    }
}