<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
}
