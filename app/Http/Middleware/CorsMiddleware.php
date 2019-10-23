<?php

namespace App\Http\Middleware;

use Closure;

class CorsMiddleware
{
    /**
     * Controle de Acesso (Cors)
     *
     * @var array
     */
    private $origins = [
        'http://localhost:8000',
        'http://localhost:8100',
        'http://localhost:8080',
        'http://192.168.0.110:8000',
        'http://192.168.0.110:8100'
    ];


    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $requestOrigin = $request->headers->get('Origin');
        if (in_array($requestOrigin, $this->origins)) {
            $allowOrigin = $requestOrigin;
        }
        if ($request->is('api/*')) {
            if (isset($allowOrigin)) {
                header("Access-Control-Allow-Origin: $allowOrigin");
            }
            header('Access-Control-Allow-Headers: Content-Type, Authorization');
            header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS');
            header('Access-Control-Request-Headers: Content-Type, Authorization');
            header('Access-Control-Expose-Headers: Authorization');
        }
        return $next($request);
    }
}
