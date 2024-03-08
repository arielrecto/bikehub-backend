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
     *     @OA\Response(response="200", description="This Api use to get all latest threads with user data")
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
