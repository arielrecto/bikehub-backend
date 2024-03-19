<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Thread;
use App\Models\ThreadTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ThreadController extends Controller
{

    /**
     * @OA\Tag(
     *     name="Threads",
     *     description="Operations related to threads"
     * )
     */

    /**
     * @OA\Schema(
     *     schema="Thread",
     *     title="Thread",
     *     description="Thread model",
     *     @OA\Property(
     *         property="id",
     *         type="integer",
     *         example="1",
     *         description="ID of the thread"
     *     ),
     *     @OA\Property(
     *         property="title",
     *         type="string",
     *         example="Sample Thread Title",
     *         description="Title of the thread"
     *     )
     * )
     */

    /**
     * @OA\Get(
     *     path="/api/threads",
     *     tags={"Threads"},
     *     summary="Get all threads",
     *     description="Retrieve all threads with pagination.",
     *     @OA\Response(
     *         response=200,
     *         description="List of threads retrieved successfully",
     *     ),
     *     security={{ "bearerAuth":{} }}
     * )
     */
    public function index()
    {
        $threads = Thread::latest()->paginate(10);

        return response([
            'threads' => $threads
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
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
            'content' => 'required',
        ]);

        $tags = $request->tags;

        $user = Auth::user();

        $thread = Thread::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => $user->id
        ]);

        collect($tags)->map(function($tag) use ($thread){
            ThreadTag::create([
                'thread_id' => $thread->id,
                'tag_id' => $tag->id
            ]);
        });

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

     /**
 * @OA\Put(
 *     path="/api/threads/{id}",
 *     tags={"Threads"},
 *     summary="Update a thread",
 *     description="Update a thread by its ID.",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the thread to update",
 *         @OA\Schema(
 *             type="string"
 *         )
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         description="Thread data to update",
 *         @OA\JsonContent(
 *             required={"title", "content"},
 *             @OA\Property(property="title", type="string", example="New Title"),
 *             @OA\Property(property="content", type="string", example="New Content")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Thread data updated",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="message",
 *                 type="string",
 *                 example="Thread data updated"
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

    public function update(Request $request, string $id)
    {


        $thread = Thread::find($id);
        $thread->update([
            'title' => $request->title ?? $thread->title,
            'content' => $request->content ?? $thread->content,
        ]);


        return response([
            'message' => 'Thread data updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */

    /**
     * @OA\Delete(
     *     path="/api/threads/{id}",
     *     tags={"Threads"},
     *     summary="Delete a thread",
     *     description="Delete a thread by its ID.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the thread to delete",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Thread successfully deleted",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Thread successfully deleted"
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

    public function destroy(string $id)
    {
        $thread = Thread::find($id);



        $thread->delete();



        return response([
            'message' => 'Thread successfully deleted'
        ], 200);
    }
}
