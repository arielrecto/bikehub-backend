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
 * @OA\Post(
 *     path="/api/login",
 *     tags={"Authentication"},
 *     summary="User Authentication",
 *     description="API endpoint for user authentication. Returns API token upon successful authentication.",
 *     @OA\RequestBody(
 *         required=true,
 *         description="User credentials",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 required={"email", "password"},
 *                 @OA\Property(
 *                     property="email",
 *                     type="string",
 *                     example="user@example.com",
 *                     description="User's email or username"
 *                 ),
 *                 @OA\Property(
 *                     property="password",
 *                     type="string",
 *                     example="password123",
 *                     description="User's password"
 *                 ),
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful authentication",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="token",
 *                 type="string",
 *                 example="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c",
 *                 description="API token for authenticated user"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="message",
 *                 type="string",
 *                 example="Invalid credentials"
 *             )
 *         )
 *     )
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
