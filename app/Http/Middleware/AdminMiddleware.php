<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Auth; 
class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!auth()->check() || auth()->user()->level !== 'admin') {
            return redirect()->route('login')->with('error', 'Unauthorized access');
        }

        return $next($request);
    }
    
    

}

