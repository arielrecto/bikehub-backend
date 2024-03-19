<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BikeShop;
use App\Models\Thread;
use Illuminate\Http\Request;

class HomeController extends Controller
{

      /**
     * @OA\Tag(
     *     name="Home",
     *     description="Operations related to users"
     * )
     *
     **/

    /**
 * @OA\Get(
 *     path="/api/",
 *     tags={"Home"},
 *     summary="Get all latest threads with user data",
 *     description="API endpoint to retrieve all latest threads along with associated user data.",
 *     security={{ "bearerAuth ":{} }},
 *     @OA\Response(
 *         response=200,
 *         description="Latest threads with user data",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="threads",
 *                 type="array",
 *                 description="List of latest threads",
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(
 *                         property="thread_id",
 *                         type="integer",
 *                         example="1",
 *                         description="ID of the thread"
 *                     ),
 *                     @OA\Property(
 *                         property="thread_title",
 *                         type="string",
 *                         example="Sample Thread Title",
 *                         description="Title of the thread"
 *                     ),
 *
 *                 )
 *             ),
 *             @OA\Property(
 *                 property="users",
 *                 type="array",
 *                 description="List of users associated with the threads",
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(
 *                         property="user_id",
 *                         type="integer",
 *                         example="1",
 *                         description="ID of the user"
 *                     ),
 *                     @OA\Property(
 *                         property="username",
 *                         type="string",
 *                         example="sample_user",
 *                         description="Username of the user"
 *                     ),
 *
 *                 )
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
 *                 example="Unauthorized access. Please provide a valid bearer token."
 *             )
 *         )
 *     )
 * )
 */

    public function index()
    {


        $threads = Thread::with([
            'user', 'comments.replies'
        ])->latest()->get();


        $shops = BikeShop::latest()->get();

        return response([
            'threads' => $threads,
            'shops' => $shops
        ], 200);
    }
}
