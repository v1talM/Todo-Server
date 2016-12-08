<?php

namespace App\Http\Middleware;

use Closure;

class cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $domains = ['*'];
        $origin = $request->server()['HTTP_ORIGIN'];
        if(isset($request->server()['HTTP_ORIGIN'])) {
            if(in_array($origin, $domains)){
                header('Access-Control-Allow-Origin: *');
                header("Access-Control-Allow-Credentials: true");
                header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
                header('Access-Control-Max-Age: 1000');
                header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');
            }
        }
        return $next($request);
    }
}
