<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTwoFactorVerified
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

                if ($user && in_array($user->role, ['admin', 'kepala_sekolah'], true) && ! session('two_factor_passed')) {
            return redirect()->route('2fa.verify');
        }

        return $next($request);
    }
}