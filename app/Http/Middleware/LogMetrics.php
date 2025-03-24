<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class LogMetrics
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
        // Start measuring the time when the request is received
        $startTime = microtime(true);
        
        // Process the request
        $response = $next($request);
        
        // Calculate the response time
        $endTime = microtime(true);
        $latency = $endTime - $startTime;

        // Log metrics
        Log::channel('metric')->info('API Metrics', [
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'endpoint' => $request->path(),
            'latency' => $latency,
            'timestamp' => now(),
        ]);
        
        // Store a count of requests by sluged URL for monitoring
        $cacheCountkey = 'request_count_' . Str::slug($request->path());
        Cache::increment($cacheCountkey);
        // dd(Cache::get($cacheCountkey));

        $cacheSumKey = 'requests_time_' . Str::slug($request->path());
        $number = Cache::get($cacheSumKey);

        // Check if the total requests time on this route is stored in Cache
        if(!$number){
            Cache::put($cacheSumKey, $latency);
        }else{
            $sum = $number + $latency;
            Cache::put($cacheSumKey, $sum);
        }
    
        return $response;
    }
}
