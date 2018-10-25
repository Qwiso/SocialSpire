<?php

namespace App\Http\Middleware;

use App\RequestLog;
use Closure;
use Illuminate\Http\Request;

class LogRequest {

    public function handle(Request $request, Closure $next)
    {
        if(!$log = RequestLog::query()->where('ip', $request->server->get('HTTP_X_FORWARDED_FOR'))->where('uri', $request->getRequestUri())->first())
        {
            $log = RequestLog::create([
                'ip'    => $request->server->get('HTTP_X_FORWARDED_FOR'),
                'uri'   => $request->getRequestUri(),
                'hits'  => 0,
            ]);
        }
        $log->increment('hits');
        $log->save();
        return $next($request);
    }
}