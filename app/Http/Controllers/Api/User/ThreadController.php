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
     * @OA\Get(
     *     path="/api/threads",
     *     tags={"Threads"},
     *     summary="Retrieve paginated list of threads",
     *     description="Retrieve a paginated list of threads, ordered by the latest.",
     *     @OA\Response(
     *         response=200,
     *         description="List of threads retrieved successfully",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(
     *                     property="id",
     *                     type="integer",
     *                     example=1,
     *                     description="ID of the thread"
     *                 ),
     *                 @OA\Property(
     *                     property="title",
     *                     type="string",
     *                     example="Sample Thread Title",
     *                     description="Title of the thread"
     *                 ),
     *                 @OA\Property(
     *                     property="content",
     *                     type="string",
     *                     example="Sample Thread Content",
     *                     description="Content of the thread"
     *                 ),
     *
     *             )
     *         )
     *     ),
     *
     * )
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $user->with('roles');
        $query = Thread::query();

        if (!$user->hasRole('admin')) {
            $query->whereStatus(['approved']);
        }

        $threads = $query->orderBy('created_at', 'desc')->paginate(10);

        return response($threads, 200);
    }


    public function randomThreads(Request $request)
    {
        $user = $request->user();
        $user->with('roles');
        $query = Thread::query();

        if (!$user->hasRole('admin')) {
            $query->whereStatus(['approved']);
        }

        $threads = $query
            ->withCount('comments')
            ->inRandomOrder()->get(3);

        return response($threads, 200);
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
     * @OA\Post(
     *     path="/api/threads",
     *     tags={"Threads"},
     *     summary="Create a new thread",
     *     description="Create a new thread with specified title, content, and tags.",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Thread data to add",
     *         @OA\JsonContent(
     *             required={"title", "content", "tags"},
     *             @OA\Property(property="title", type="string", example="Sample Thread Title"),
     *             @OA\Property(property="content", type="string", example="Sample Thread Content"),
     *             @OA\Property(
     *                 property="tags",
     *                 type="array",
     *                 @OA\Items(type="integer", example="1"),
     *                 description="List of tag IDs associated with the thread"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Thread added successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Thread Is Added"),
     *             @OA\Property(property="thread", type="object", example={"id": 1, "title": "Sample Thread Title", "content": "Sample Thread Content"}),
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(property="errors", type="object"),
     *         )
     *     ),
     *     security={{ "bearerAuth":{} }}
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

        collect($tags)->map(function ($tag) use ($thread) {
            ThreadTag::create([
                'thread_id' => $thread->id,
                'tag_id' => $tag->id
            ]);
        });

        $thread->load('user');

        return response([
            'message' => 'Thread Is Added',
            'thread' => $thread
        ]);
    }

    /**
     * Display the specified resource.
     */

    /**
     * @OA\Get(
     *     path="/api/threads/{id}",
     *     tags={"Threads"},
     *     summary="Retrieve a thread by ID",
     *     description="Retrieve a thread by its ID along with associated tags and comments.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the thread to retrieve",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Thread retrieved successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="thread",
     *                 type="object",
     *                 description="Details of the retrieved thread",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="title", type="string", example="Sample Thread Title"),
     *                 @OA\Property(property="content", type="string", example="Sample Thread Content"),
     *                 @OA\Property(
     *                     property="comments",
     *                     type="array",
     *                     description="List of comments associated with the thread",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="content", type="string", example="Sample Comment Content")
     *
     *                     )
     *                 ),
     *                 @OA\Property(
     *                     property="tags",
     *                     type="array",
     *                     description="List of tags associated with the thread",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="name", type="string", example="Sample Tag Name")
     *
     *                     )
     *                 ),
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
    public function show(Thread $thread)
    {
        return response([
            'thread' => $thread
        ], 200);
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

    public function update(Request $request, Thread $thread)
    {
        $thread->update($request->all());

        return response([
            'message' => 'Thread data updated',
            'thread' => $thread->fresh()
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
            'message' => 'Thread successfully deleted',
            'thread' => $thread
        ], 200);
    }
}
