<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class ClientController extends Controller
{
    public function redirectTo(Request $request)
    {
        $ssoLoginUrl = 'http://ecommerce-app.test/client/login';
        $redirectBack = urlencode(route('client.callback'));

        return redirect()->away("$ssoLoginUrl?redirect=$redirectBack");
    }

    public function handleCallback(Request $request)
    {
        $token = $request->query('token');

        if (!$token) {
            return abort(403, 'No token received');
        }

        // Save token to session
        session(['sso_token' => $token]);

        // Validate token by calling SSO Server
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => "Bearer $token"
        ])->get('http://ecommerce-app.test/api/auth/me');

        if (!$response->ok()) {
            return abort(403, 'Invalid token');
        }

        $clientUser = $response->json();

        // Find or create local user
        $user = User::firstOrCreate(
            ['email' => $clientUser['email']],
            ['name' => $clientUser['name'], 'password' => $clientUser['password']]
        );

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
