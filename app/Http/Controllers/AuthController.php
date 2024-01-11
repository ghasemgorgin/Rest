<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request){
        $validate=$request->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);
        if(!Auth::attempt($validate)){
             return response()->json([
                'message'=>'login failed'
             ],401);  
        }
       $user=User::where('email',$validate['email'])->first();
         return response()->json([
            'access_token'=>$user->createToken('api_token')->plainTextToken,
            'token_type'=>'Bearer',
         ]);
    }
}
