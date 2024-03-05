<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ThreadController extends Controller
{

    /**
     * @OA\Tag(
     *     name="Threads",
     *     description="Operations related to users"
     * )
     *
     **/


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

    /**
     * @OA\POST(
     *     path="/api/users/threads",
     *     tags={"Threads"},
     *     @OA\Response(response="200", description="This Api use for Post a new Thread")
     * )
     */



    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required',
            'content' => 'required'
        ]);

        $user = Auth::user();

        $thread = Thread::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => $user->id
        ]);




        return response([
            'message' => 'Thread Is Added',
            'thread' => $thread
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
