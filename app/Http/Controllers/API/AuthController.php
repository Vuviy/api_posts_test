<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request){
        $data = $request->validate([
            'name'=>'required|string',
            'email'=>'required|string|email|unique:users',
            'password'=>'required|min:8'
        ]);
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        $token = $user->createToken($user->name.'-AuthToken', ['user'])->plainTextToken;

        return response()->json([
            'message' => 'user created',
            'access_token' => $token,
        ]);
    }

    public function login(Request $request){
        $data = $request->validate([
            'email'=>'required|string|email',
            'password'=>'required|min:8'
        ]);
        $user = User::where('email',$data['email'])->first();
        if(!$user || !Hash::check($data['password'],$user->password)){
            return response()->json([
                'message' => 'invalid credentials'
            ],401);
        }

        if($user->is_admin){
            $token = $user->createToken($user->name.'-AuthToken', ['admin'])->plainTextToken;
        }

        if(!$user->banned){
            $token = $user->createToken($user->name.'-AuthToken', ['user'])->plainTextToken;
        }else{
            return response()->json([
                'message' => 'You are blocked',
            ]);
        }
        return response()->json([
            'access_token' => $token,
        ]);
    }


    public function logout(){
        auth()->user()->tokens()->delete();

        return response()->json([
            "message"=>"logged out"
        ]);
    }
}
