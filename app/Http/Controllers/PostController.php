<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Auth;
use App\Utilities\Utils;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $paginate = empty($request['paginate']) ? 2 : Utils::setPaginate($request['paginate']);
        $data = Post::with(['user', 'comments.user', 'comments.replies.user'])
            ->paginate($paginate);;

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
    public function store(PostRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('images', 'public');
        }

        $data = Post::create(array_merge(
            $validated,
            ['user_id' => Auth::id()]
        ));

        return response()->json([
            'data' => $data,
            'message' => 'Post created successfully',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = Post::with(['user', 'comments.user', 'comments.replies.user'])->find($id);

        if (!$data) {
            return response()->json([
                'message' => 'Post not found',
            ], 404);
        }

        return response()->json([
            'data' => $data,
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, $id)
    {
        $data = Post::findOrFail($id);

        if ($data->user_id !== Auth::id()) {
            return response()->json([
                'message' => 'You are not authorized to update this post',
            ], 403);
        }

        $data->update($request->validated());

        return response()->json([
            'data' => $data,
            'message' => 'Post updated successfully',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = Post::findOrFail($id);

        if ($data->user_id !== Auth::id()) {
            return response()->json([
                'message' => 'You are not authorized to delete this post',
            ], 403);
        }

        if (!$data) {
            return response()->json([
                'message' => 'Post not found',
            ], 404);
        }

        $data->delete();

        return response()->json([
            'message' => 'Post deleted successfully',
        ], 200);
    }
}
