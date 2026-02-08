<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureUserRole
{
    public function handle(Request $request, Closure $next, $role): Response
    {
        if (Auth::user()->role !== $role) {
            // Kalau admin salah kamar ke dashboard user, atau sebaliknya
            return redirect('/dashboard'); 
        }
        return $next($request);
    }
}