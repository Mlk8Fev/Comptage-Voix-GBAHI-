<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckBureauAccess
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        // Les admins ont accès à tout
        if ($user->isAdmin()) {
            return $next($request);
        }

        // Pour les représentants, vérifier l'accès au bureau
        $bureauVoteId = $request->route('bureauVoteId');
        
        if ($bureauVoteId && !$user->canAccessBureau($bureauVoteId)) {
            abort(403, 'Vous n\'avez pas accès à ce bureau de vote.');
        }

        return $next($request);
    }
}
