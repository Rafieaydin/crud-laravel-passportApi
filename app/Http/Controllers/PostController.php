<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return response()->json([
            'status' => 200,
            'data' => Post::with('user')->get()
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'image' => 'required|image',
            'user_id' => 'required'
        ]);
        $name =  $request->file('image')->getClientOriginalName();
        $url = public_path('image/post');
        if (!File::exists($url. '/' . $name)) {
            $request->file('image')->move('image/post', $name);
        }
        $post = Post::create([
            'title' => Str::slug($request->title) ,
            'content' => $request->content,
            'image' => '/image/post/' . $request->file('image')->getClientOriginalName(),
            'user_id' => $request->user_id
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Post created successfully',
            'data' => $post
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return response()->json([
            'status' => 200,
            'data' => $post
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updates(Request $request,  $id)
    {

        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'image' => 'required|image',
            'user_id' => 'required'
        ]);
        $post = Post::find($id);
        if (!$post) {
            return response()->json([
                'status' => 404,
                'message' => 'Post not found'
            ], 404);
        }
        if ($request->hasFile('image')) {
            $name =  $request->file('image')->getClientOriginalName();
            $url = public_path('image/post');
            if (File::exists(public_path().$post->image)) {
                File::delete(public_path().$post->image);
            }
            $request->file('image')->move('image/post', $name);
            $post->update([
                'title' => Str::slug($request->title) ,
                'content' => $request->content,
                'image' => '/image/post/' . $request->file('image')->getClientOriginalName(),
                'user_id' => $request->user_id
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Post updated successfully',
                'data' => $post
            ], 200);
        } else {
            $post->update([
                'title' => $request->title,
                'content' => $request->content,
                'user_id' => $request->user_id
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Post updated successfully',
                'data' => $post
            ], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Post::destroy($id);
        return response()->json([
            'status' => 200,
            'message' => 'Post deleted successfully'
        ], 200);
    }
}
