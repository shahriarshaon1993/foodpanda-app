<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthenticatedApiController extends Controller
{
    public function getUser()
    {
        $user = auth('api')->user();

        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'password' => $user->getAttributes()['password'],
        ]);
    }

    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());
        Log::info('JWT token invalidated successfully', [
            'user' => auth('api')->user()
        ]);

        return response()->json(['message' => 'SSO logout success']);
    }
}
