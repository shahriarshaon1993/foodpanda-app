<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(Request $request)
    {
        $redirectUrl = $request->query('redirect', '/dashboard');

        if (Auth::check()) {
            $token = JWTAuth::fromUser(Auth::user());

            return redirect()->away($redirectUrl . '?token=' . $token);
        }

        session(['sso_redirect' => $request->query('redirect')]);
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        // Generate JWT token
        $user = Auth::user();
        $token = JWTAuth::fromUser($user);

        $redirect = session('sso_redirect', route('dashboard'));

        // clear session value after use
        session()->forget('sso_redirect');

        return redirect()->away($redirect . '?token=' . $token);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        $redirectUrl = $request->query('redirect_to', '/');

        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect($redirectUrl);
    }
}
