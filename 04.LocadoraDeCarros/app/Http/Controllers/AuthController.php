<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credenciais = $request->all(['email', 'password']);
        
        $token = auth('api')->attempt($credenciais);

        if (!$token) {
            return response()->json(['erro' => 'usuário ou senha inválidos'], Response::HTTP_FORBIDDEN);
        }

        return response()->json(['token' => $token], Response::HTTP_OK);
    }

    public function logout()
    {
        return 'logout';
    }

    public function refresh()
    {
        return 'refresh';
    }

    public function me()
    {
        return 'me';
    }
}
