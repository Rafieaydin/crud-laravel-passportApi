<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    /**
     * Registration Req
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|min:4',
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $token = $user->createToken('PassportAuth')->accessToken;

        return response()->json([
            'status'=> 200,
            'message' => 'Register successfully',
            'token' => $token
        ], 200);
    }

    /**
     * Login Req
     */
    public function login(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (auth()->attempt($data)) {
            $token = auth::user()->createToken('PassportAuth')->accessToken; // emang error gatau kenapa
            Auth::user()['token'] = $token;
            return response()->json([
                'status' => 200,
                'message' => 'Login successfully',
                'data' => Auth::user()
            ], 200);
        } else {
            return response()->json([
                'status' => 401,
                'error' => 'Unauthorised'
            ], 401);
        }
    }
    public function userInfo()
    {
     $user = auth()->user();

     return response()->json([
        'status' => 200,
        'message' => 'User Info',
        'user' => $user
    ], 200);
    }
}
