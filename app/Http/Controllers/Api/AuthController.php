<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request){
        $user = User::where('email', $request->email)->first();

        if(!$user || !\Hash::check($request->password, $user->password)){
            return response()->json([
                'mesage' => 'user not found'
            ], 401);
        }

        $token = $user->createToken('token')->plainTextToken;

        return response()->json([
            'mesage' => 'success',
            'user' => $user,
            'token' => $token
        ], 200);
    }

    public function logout(Request $request){
        $user = $request->user();
        $user->currentAccessToken()->delete();

        return response()->json([
            'mesage' => 'Logout seccess'
        ],200);
    }


}
