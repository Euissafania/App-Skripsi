<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        //multiple role
         if (Auth::check()) {
            $roles = explode('|', $role);
            foreach ($roles as $r) {
                if (Auth::user()->role == trim($r)) {
                    return $next($request);
                }
            }
        }
        
        return redirect('/access-denied'); 
    }
    
}
