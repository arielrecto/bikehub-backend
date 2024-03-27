<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use OpenApi\Annotations as OA;


/**
 * @OA\Info(title="Bike Hub Api", version="0.1")
 */


class RegisterController extends Controller
{
  /**
 * @OA\Post(
 *     path="/api/register",
 *     tags={"Authentication"},
 *     summary="Register a new user",
 *     description="Register a new user with email, name, and password.",
 *     @OA\RequestBody(
 *         required=true,
 *         description="User registration details",
 *         @OA\JsonContent(
 *             required={"email", "name", "password", "password_confirmation"},
 *             @OA\Property(property="email", type="string", format="email", description="User email address"),
 *             @OA\Property(property="name", type="string", description="User name"),
 *             @OA\Property(property="password", type="string", format="password", description="User password"),
 *             @OA\Property(property="password_confirmation", type="string", format="password", description="Confirm password")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User registered successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Registration successful")
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Validation error",
 *         @OA\JsonContent(
 *             @OA\Property(property="errors", type="object", description="Validation errors")
 *         )
 *     )
 * )
 */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'email' => 'required|unique:users,email',
            'name' => 'required',
            'password' => 'required|confirmed'
        ]);

        if($validator->fails()){
            return response([
                'errors' => $validator->errors()
            ], 422);
        }



        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password
        ]);

        $token = $user->createToken('API TOKEN')->plainTextToken;

        return response([
            'message' => 'Register Success',
            'token' => $token,
            'user' => $user
        ], 200);
    }
}
