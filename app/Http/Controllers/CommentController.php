<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Comment::get();

        return response()->json([
            'data' => $data,
        ], 200);
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
    public function store(CommentRequest $request)
    {
        $data = Comment::create(array_merge(
            $request->validated(),
            ['user_id' => Auth::id()]
        ));

        $data->load('user');
        
        return response()->json([
            'data' => $data,
            'message' => 'Comment created successfully',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = Comment::find($id);

        if (!$data) {
            return response()->json([
                'message' => 'Comment not found',
            ], 404);
        }

        return response()->json([
            'data' => $data,
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CommentRequest $request, $id)
    {
        $data = Comment::findOrFail($id);

        if ($data->user_id !== Auth::id()) {
            return response()->json([
                'message' => 'You are not authorized to update this comment',
            ], 403);
        }

        $data->update($request->validated());

        return response()->json([
            'data' => $data,
            'message' => 'Comment updated successfully',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = Comment::findOrFail($id);
        
        if ($data->user_id !== Auth::id()) {
            return response()->json([
                'message' => 'You are not authorized to delete this comment',
            ], 403);
        }

        if (!$data) {
            return response()->json([
                'message' => 'Comment not found',
            ], 404);
        }

        $data->delete();

        return response()->json([
            'message' => 'Comment deleted successfully',
        ], 200);
    }
}
