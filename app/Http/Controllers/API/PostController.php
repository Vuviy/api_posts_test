<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function get($id = null)
    {

        if($id){
            $post = Post::query()->with('comments');
            if(!auth()->user())
            {
                $post = $post->where('publish_at', "!=", null);
            }
            $post = $post->find($id);
            if(!$post){
                return response()->json(['message'  => 'post with id not exist'], 404);
            }
            return  new PostResource($post);
        }

        $posts = Post::query()->with('comments');
        if(!auth()->user())
        {
            $posts = $posts->where('publish_at', "!=", null);
        }
        $posts = $posts->get();
        return new PostCollection($posts);
    }

    public function getForAuthor($author_id = null, $id = null)
    {

        if(auth()->user()->tokenCan('admin') || $author_id == auth()->user()->id )
        {
            if($id){
                $post = Post::query()->with('comments')->where('user_id', $author_id)->find($id);

                if(!$post){
                    return response()->json(['message'  => 'post with id not found'], 404);
                }
                return  new PostResource($post);
            }

            $posts = Post::query()->with('comments')->where('user_id', $author_id)->get();
            return new PostCollection($posts);
            }
        return response()->json(['message' => 'access is denied'], 419);
    }

    public function create(PostRequest $request)
    {

        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;
        $post = Post::query()->create($data);

        if(!$post){
            return response()->json(['message' => 'error'], 400);
        }
        return response()->json(['message' => 'post created', 'id' => $post->id], 201);

    }
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'title' => 'min:8|max:255',
            'text' => 'min:8',
        ]);

        $post = Post::query()->find($id);

        if(auth()->user()->tokenCan('admin') || $post->user_id == auth()->user()->id )
        {
            if(!$post){
                return response()->json(['message' => 'post not found'], 404);
            }
            $post->update($data);

            return response()->json(['message' => 'post updated', 'id' => $post->id], 202);
        }

        return response()->json(['message' => 'access is denied'], 419);



    }
    public function delete($id)
    {
        $post = Post::query()->find($id);

        if(!$post){
            return response()->json(['message' => 'post not found'], 404);
        }

        if(auth()->user()->tokenCan('admin') || $post->user_id == auth()->user()->id )
        {
            $post->delete();
            return response()->json(['message' => 'post deleted', 'id' => $post->id], 200);
        }

        return response()->json(['message' => 'access is denied'], 419);


    }
    public function publish($id)
    {
        $post = Post::query()->find($id);

        if(!$post){
            return response()->json(['message' => 'post not found'], 404);
        }

        if(auth()->user()->tokenCan('admin') || $post->user_id == auth()->user()->id){
            $message = 'Post publish';
            if($post->publish_at){
                $post->publish_at = null;
                $post->save();
                $message = 'Post unpublish';
            } else{
                $post->publish_at = now();
                $post->save();
            }
            return response()->json(['message' => $message, 'id' => $post->id], 200);
        }

        return response()->json(['message' => 'access is denied'], 419);
    }
}
