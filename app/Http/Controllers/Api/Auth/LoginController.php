<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{

     /**
     * @OA\POST(
     *     path="/api/login",
     *     tags={"Authentication"},
     *     @OA\Response(response="200", description="This Api use for user authentication that return api token")
     * )
     */


    public function store(Request $request){


        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required'
        ]);

        if($validator->fails()){
            return response([
                'error' => $validator->errors()
            ], 422);
        }

        if(!Auth::attempt($request->only(['email', 'password']))){
            return response([
                'errors' => [
                    'message' => 'Incorrect Credentials'
                ]
            ], 401);
        }

        $user = User::where('email', $request->email)->first();

        $token = $user->createToken('API TOKEN')->plainTextToken;


        return response([
            'message' => 'login success',
            'token' => $token,
            'user' => $user
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/logout",
     *     tags={"Authentication"},
     *     @OA\Response(response="200", description="This Api use for The Authenticated User to logout by revoking the current api token")
     * )
     */


    public function logout(){


        $user = Auth::user();

        $user->tokens()->delete();

        return response([
            'message' => 'logout success',
        ], 200);
    }
}
