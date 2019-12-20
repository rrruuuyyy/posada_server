<?php

namespace App\Http\Middleware;

use Closure;

class CheckBearer
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
        try {
            $request->user();
            return $next($request);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['status'=>false,'mensaje'=>$th->getMessage()]);
        }
    }
}
