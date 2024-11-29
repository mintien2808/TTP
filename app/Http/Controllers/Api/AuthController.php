<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller{
    public function login(Request $request){
        $credentials = $request->validate([
            'name'=> ['required'],
            'password' => 'required',
        ]);
        if (!Auth::attempt($credentials, $remember)) {
            return response([
                'message' => 'Sai Thông Tin Đăng Nhập'
            ], 422);
        }
        $user = Auth::user();
        $token = $user->createToken('main')->plainTextToken;
        return response([
            'user' => new UserResource($user),
            'token' => $token
        ]);
    }

    public function logout(){
        $user = Auth::user();
        $user->currentAccessToken()->delete();
        return response('', 204);
    }

    public function getUser(Request $request){
        return new UserResource($request->user());
    }
}
