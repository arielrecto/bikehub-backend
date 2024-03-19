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
     *     path="/api/index",
     *     tags={"Home"},
     *     summary="Get all threads and bike shops",
     *     description="Retrieve all threads along with associated user, comments, tags, and retrieve all bike shops.",
     *     @OA\Response(
     *         response=200,
     *         description="Threads and bike shops retrieved successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="threads",
     *                 type="array",
     *                 description="List of threads",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="title", type="string", example="Sample Thread Title"),
     *                     @OA\Property(property="content", type="string", example="Sample Thread Content"),
     *                     @OA\Property(
     *                         property="user",
     *                         type="object",
     *                         description="Details of the user who created the thread",
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="name", type="string", example="John Doe"),
     *
     *                     ),
     *                     @OA\Property(
     *                         property="comments",
     *                         type="array",
     *                         description="List of comments associated with the thread",
     *                         @OA\Items(
     *                             type="object",
     *                             @OA\Property(property="id", type="integer", example=1),
     *                             @OA\Property(property="content", type="string", example="Sample Comment Content"),
     *
     *                         )
     *                     ),
     *                     @OA\Property(
     *                         property="tags",
     *                         type="array",
     *                         description="List of tags associated with the thread",
     *                         @OA\Items(
     *                             type="object",
     *                             @OA\Property(property="id", type="integer", example=1),
     *                             @OA\Property(property="name", type="string", example="Sample Tag Name"),
     *
     *                         )
     *                     ),
     *
     *                 )
     *             ),
     *             @OA\Property(
     *                 property="shops",
     *                 type="array",
     *                 description="List of bike shops",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="Sample Bike Shop Name"),
     *                     @OA\Property(property="description", type="string", example="Sample Bike Shop Description"),
     *
     *                 )
     *             )
     *         )
     *     ),
     *     security={{ "bearerAuth":{} }}
     * )
     */

    public function index()
    {


        $threads = Thread::with([
            'user', 'comments.replies', 'tags'
        ])->latest()->get();


        $shops = BikeShop::latest()->get();

        return response([
            'threads' => $threads,
            'shops' => $shops
        ], 200);
    }
}
