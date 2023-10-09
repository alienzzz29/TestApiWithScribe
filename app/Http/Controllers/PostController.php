<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $posts = Post::all();

        if($posts -> count() >0){
            return response()->json([
                'status' => 'success',
                'posts' => $posts
            ]);
        }else{
            return response()->json([
                'message' => 'Posts empty'
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'text' => 'required|max:166'
        ]);

        if($validated -> fails()){
            return response()->json([
                'message' => $validated->messages()
            ]);
        }else{
            Post::create($request->all());

            $posts = Post::all();

            return response()->json([
                'message' => 'Post added successfully',
                'post' => $posts
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $post = Post::find($id);

        if($post){
            return response()->json([
                'status' => 'success',
                'post' => $post
            ]);
        }else{
            return response()->json([
                'message' => 'No post found'
            ]);
        }
    }

  
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $validated = Validator::make($request->all(),[
            'user_id' => 'required|integer',
            'text' => 'required|max:166'
        ]);

        if($validated -> fails()){
            return response()->json([
                'message' => $validated->messages()
            ]);
        }else{
            $post = Post::find($id);
            
            if ($post) {
                # code...
                $post->update($request->all());

                return response()->json([
                    'message' => 'Post updated successfully',
                    'post' => $post
                ]);
            }else{
                return response()->json([
                    'message' => 'No post found'
                ]);
            }

            
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        //
        $post = Post::find($id);
        if($post){
            $post->delete();
            $posts = Post::all();
            return response()->json([
                'message' => 'Post deleted successfully',
                'remaining posts' => $posts
            ]);
        }else{
            return response()->json([
                'message' => 'No post found'
            ]);
        }
    }
}
