<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PreventBackHistory
{
    public function handle(Request $request, Closure $next): mixed
    {
        $response = $next($request);

        // Download responses-க்கு header add பண்ண வேண்டாம்
        // BinaryFileResponse, StreamedResponse போன்றவை
        if (!method_exists($response, 'header')) {
            return $response;
        }

        return $response
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }
}