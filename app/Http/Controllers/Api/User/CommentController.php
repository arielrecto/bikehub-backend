<?php

namespace App\Http\Controllers\Api\User;

use App\Models\Thread;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Tag(
 *     name="Comment",
 *     description="This is related to the threads"
 * )
 *
 **/



class CommentController extends Controller
{
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
     * @OA\Post(
     *  path="/api/users/threads/{id}/comment",
     *     tags={"Threads"},
     * security={
     *         {"bearerAuth": {}}
     *     },
     *  @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the Thread to retrieve",
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     * @OA\RequestBody(
     *         required=true,
     *         description="Comment content",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"content"},
     *                 @OA\Property(
     *                     property="content",
     *                     type="string",
     *                     example="This is the comment content."
     *                 )
     *             )
     *         )
     *     ),
     * @OA\Response(
     *         response=200,
     *         description="This API is used to add a comment in the specific thread",
     *         @OA\JsonContent(
     *             type="object",
     *               @OA\Property(
     *                 property="status",
     *                 type="string",
     *                 example="success"
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Comment added successfully"
     *             )
     *         )
     *     )
     * )
     *
     *
     */


    public function store(Request $request, $id)
    {

        $request->validate([
            'content' => 'required'
        ]);

        $thread = Thread::find($id);

        $user = Auth::user();

        $comment = Comment::create([
            'content' => $request->content,
            'thread_id' => $thread->id,
            'user_id' => $user->id,
        ]);


        return response([
            'message' => 'Comment Added',
            'comment' => $comment
        ], 200);
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
