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
     * @OA\Tag(
     *     name="Authentication",
     *     description="Operations related to users"
     * )
     *
     *
     **/

    /**
     * @OA\POST(
     *     path="/api/register",
     *     tags={"Authentication"},
     *     @OA\Response(response="200", description="This Api use for user registration")
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



        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password
        ]);


        return response([
            'message' => 'Register Success'
        ], 200);
    }
}
