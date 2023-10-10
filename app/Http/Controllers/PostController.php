<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * All Posts
     * 
     * Shows all posts
     * @response 200 {"status": "success","posts": [{"id": 4,"user_id": 10,"text": "Good Evening!","created_at": "2023-10-09T08:21:34.000000Z","updated_at": "2023-10-09T08:22:25.000000Z"}]}
     * 
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
     * Create Post
     * 
     * Creates a post
     * @bodyParam user_id int required user_id
     * @bodyParam text string required text
     * 
     * @response 200 {"message":"Post added successfully","post":[{"id":4,"user_id":10,"text":"Good Evening!","created_at":"2023-10-09T08:21:34.000000Z","updated_at":"2023-10-09T08:22:25.000000Z"},{"id":5,"user_id":3,"text":"Good Morning!","created_at":"2023-10-10T01:08:30.000000Z","updated_at":"2023-10-10T01:08:30.000000Z"}]}
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
     * Find Post
     * 
     * Find post by ID
     * @urlParam id int required post ID
     * @response 200 {"status":"success","post":{"id":4,"user_id":10,"text":"Good Evening!","created_at":"2023-10-09T08:21:34.000000Z","updated_at":"2023-10-09T08:22:25.000000Z"}}
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
     * Update Post
     * 
     * update post by ID
     * @urlParam id integer required ID of post.
     * 
     * @response 200 {"message":"Post updated successfully","post":{"id":4,"user_id":"10","text":"Good Evening!","created_at":"2023-10-09T08:21:34.000000Z","updated_at":"2023-10-09T08:22:25.000000Z"}}
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
     * Delete Post
     * 
     * Deletes post by ID
     * @urlParam id integer required ID of post.
     * @response 200 {"message":"Post deleted successfully","remaining posts":[{"id":5,"user_id":3,"text":"Good Morning!","created_at":"2023-10-10T01:08:30.000000Z","updated_at":"2023-10-10T01:08:30.000000Z"},{"id":6,"user_id":3,"text":"Good Morning!","created_at":"2023-10-10T01:20:08.000000Z","updated_at":"2023-10-10T01:20:08.000000Z"}]}
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
