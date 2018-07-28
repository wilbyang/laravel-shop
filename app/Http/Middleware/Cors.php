<?php

namespace App\Http\Middleware;

use Closure;
use function GuzzleHttp\Promise\all;
use Illuminate\Support\Facades\DB;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     * 'Access-Control-Allow-Credentials' => 'true',
     * 'Access-Control-Max-Age'           => '86400',
     * 'Access-Control-Allow-Headers'     => 'Content-Type, Authorization, X-Requested-With',
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $headers = [
//            'Access-Control-Allow-Methods'     => 'GET', //'POST, GET, OPTIONS, PUT, DELETE',
//            'Access-Control-Allow-Headers'     => 'Content-Type, X-Auth-Token, Origin, Authorization'
        ];
        if ($request->hasHeader('Referer'))
        {
            $referer = $request->headers->get('Referer');

            $parsedUrl = parse_url($referer);
            $host = $parsedUrl['host'];

            if ( DB::table('tenants')->where('site', '=', $host)->first())
            {
                $allowed_origin = $parsedUrl['scheme'] . '://' . $host;
                $headers['Access-Control-Allow-Origin'] = $allowed_origin;

            }

        }


        if ($request->isMethod('OPTIONS') && $request->hasHeader('Access-Control-Request-Method') &&
        $request->hasHeader('Origin'))
        {
            $headers['Access-Control-Allow-Headers'] = 'Content-Type, Authorization';
            $headers['Access-Control-Allow-Methods'] = 'GET';
            return response()->json('{"method":"OPTIONS"}', 200, $headers);
        }



        //$headers['X-Auth-Token'] = $request->user()->tenant->site;
        foreach($headers as $key => $value)
        {
            $response->header($key, $value);
        }

        return $response;
    }
}
