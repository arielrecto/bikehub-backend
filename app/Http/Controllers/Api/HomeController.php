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
 /**
/**
 * @OA\Get(
 *     path="/api/index",
 *     tags={"Index"},
 *     summary="Get all threads and bike shops",
 *     description="Retrieve all threads and bike shops.",
 *     @OA\Response(
 *         response=200,
 *         description="List of threads and bike shops retrieved successfully",
 *     ),
 *     security={{ "bearerAuth":{} }}
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
