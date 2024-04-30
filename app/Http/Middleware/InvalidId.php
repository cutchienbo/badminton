<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;
use Faker\Provider\ar_EG\Internet;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Ramsey\Uuid\Type\Integer;
use Symfony\Component\HttpFoundation\Response;

class InvalidId
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $check_id = DB::table('password')->get();

        if($request->session()->has('id_token')){
            return $next($request);
        }
        else if($request->id == $check_id[0]->password){
            $request->session()->put('id_token', $request->id);

            return $next($request);
        }
        
        return abort(404);
    }
}
