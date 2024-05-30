<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Thread;
use Illuminate\Http\Request;

class UpvoteController extends Controller
{

    protected $upvoteables = [
        'comment' => Comment::class,
        'thread' => Thread::class
    ];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id' => 'numeric',
            'model' => 'string'
        ]);

        $model = $this->upvoteables[$validated['model']];

        /**
         * @var Comment|Thread 
         */
        $target_model = $model::find($validated['id']);

        $target_model->toggleUpvoteBy($request->user());

        $upvoted = $target_model->fresh();

        return [
            'message' => 'updated upvote',
            'upvoted' => $upvoted,
            'model' => $validated['model']
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
