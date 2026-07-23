<?php



namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class User
{

    public function handle($request, Closure $next)
    {
        if (Auth::user()->role == 3) {

            return $next($request);
        } else {
            return redirect('/')->with(['eeor'=>'dddddd']);
        }
    }
}
