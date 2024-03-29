<?php

namespace App\Http\Controllers\Api\User;

use App\Models\Thread;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Tag(
 *     name="Comments",
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
     *     path="/api/threads/{id}/comment",
     *     tags={"Comments"},
     *     summary="Add a comment to a thread",
     *     description="Add a comment to a thread by its ID.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the thread to add a comment to",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Comment data to add",
     *         @OA\JsonContent(
     *             required={"content"},
     *             @OA\Property(property="content", type="string", example="This is a comment")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Comment added successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Comment Added"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Thread not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Thread not found"
     *             )
     *         )
     *     ),
     *     security={{ "bearerAuth":{} }}
     * )
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

    /**
     * @OA\Put(
     *     path="/api/comments/{id}",
     *     tags={"Comments"},
     *     summary="Update a comment",
     *     description="Update a comment by its ID.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the comment to update",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Updated comment data",
     *         @OA\JsonContent(
     *             required={"content"},
     *             @OA\Property(property="content", type="string", example="Updated content")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Comment updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Comment Updated"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Comment not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Comment not found"
     *             )
     *         )
     *     ),
     *     security={{ "bearerAuth":{} }}
     * )
     */

    public function update(Request $request, string $id)
    {
        $request->validate([
            'content' => $request->content
        ]);


        $comment = Comment::find($id);

        $comment->update([
            'content' => $request->comment
        ]);


        return response([
            'message' => 'Comment Updated'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */

    /**
     * @OA\Delete(
     *     path="/api/comments/{id}",
     *     tags={"Comments"},
     *     summary="Delete a comment",
     *     description="Delete a comment by its ID.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the comment to delete",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Comment deleted successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Comment deleted"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Comment not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Comment not found"
     *             )
     *         )
     *     ),
     *     security={{ "bearerAuth":{} }}
     * )
     */

    public function destroy(string $id)
    {
        $comment = Comment::find($id);

        $comment->delete();


        return response([
            'message' => 'Comment deleted'
        ]);
    }
}
