<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api',['except' => ['login']]);
    }


    public function login()
    {
        $credentials = request(['email', 'password']);
        if(! $token = auth('api')->attempt($credentials)){
            return response()->json(['error' => 'Unauthorized Login'], 401);
        }
        return $this->respondWithToken($token);
    }
    public function logout()
    {
        auth('api')->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTl() * 60
        ]);
    }
}
