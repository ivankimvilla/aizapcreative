<?php

namespace App\Http\Middleware;

use App\Models\SiteVisit;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TrackSiteVisit
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($this->shouldTrack($request)) {
            try {
                SiteVisit::create([
                    'url' => $request->getPathInfo() ?: '/',
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'referer' => $request->header('referer'),
                ]);
            } catch (\Throwable $e) {
                Log::warning('Unable to record site visit', ['exception' => $e->getMessage()]);
            }
        }

        return $response;
    }

    protected function shouldTrack(Request $request): bool
    {
        if ($request->is('admin/*') || $request->is('storage/*') || $request->is('_debugbar/*')) {
            return false;
        }

        return $request->method() === 'GET';
    }
}
