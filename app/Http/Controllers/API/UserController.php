<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function get(Request $request)
    {
        return new UserResource($request->user());
    }


    public function banUser($id)
    {
        $user = User::query()->find($id);

        if(!$user){
            return response()->json(['message' => 'user not found'], 404);
        }
        $message = 'User is banned';

        if($user->banned){
            $user->update(['banned' => null]);
            $message = 'User user is unbanned';
        } else{
            $user->update(['banned' => 1]);
        }

        return response()->json(['message' => $message], 200);

    }
}
