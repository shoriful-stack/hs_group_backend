<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class ApiCacheMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!env('API_CACHE', false)) {
            return $next($request);
        }

        $method = $request->method();
        $key = $this->cacheKey($request);
        $ttl = env('API_CACHE_TTL', 3600);

        if ($method === 'GET') {

            if (Cache::has($key)) {
                return new Response(
                    Cache::get($key),
                    200,
                    [
                        'Content-Type' => 'application/json',
                        'X-Cache' => 'HIT'
                    ]
                );
            }

            $response = $next($request);

            Cache::put($key, $response->getContent(), $ttl);

            return $response->header('X-Cache', 'MISS');
        }

        if (in_array($method, ['POST', 'PUT', 'PATCH', 'DELETE'])) {
            $this->clearCacheForResource($request);
        }

        return $next($request);
    }


    private function cacheKey($request): string
    {
        $path = strtolower(preg_replace('#^api/#', '', $request->path()));
        $path = str_replace('/', '_', $path);

        $query = $request->query();
        if (!empty($query)) {
            return "api_cache_{$path}_" . md5(json_encode($query));
        }

        return "api_cache_{$path}";
    }


    private function clearCacheForResource($request)
    {
        $path = strtolower(preg_replace('#^api/#', '', $request->path()));
        $base = explode('/', $request->path())[1] ?? null;

        Cache::delete("api_cache_" . str_replace('/', '_', $path));

        if ($base) {
            $prefix = "api_cache_" . $base;
            foreach (Cache::getIterator() as $k => $v) {
                if (str_starts_with($k, $prefix)) {
                    Cache::forget($k);
                }
            }
        }
    }
}
