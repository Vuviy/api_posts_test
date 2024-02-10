<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\PostRequest;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    public function create(CommentRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;

        $className = 'App\Models\\'.ucfirst($data['type']);

        if(!class_exists($className)){
            return response()->json(['message' => 'type not found'], 404);
        }

        $class = new $className();

        if(!$class::find($data['post_id'])){
            return response()->json(['message' => $data['type'].' not found'], 404);
        }

        $data['commentable_id'] = $data['post_id'];
        $data['commentable_type'] = $className;

        $comment = Comment::query()->create($data);

        if(!$comment){
            return response()->json(['message' => 'error'], 400);
        }
        return response()->json(['message' => 'comment created', 'id' => $comment->id], 201);
    }

    public function delete($id)
    {

        $comment = Comment::query()->find($id);

        if(!$comment){
            return response()->json(['message' => 'comment not found'], 404);
        }

        $comment->delete();

        return response()->json(['message' => 'comment deleted', 'id' => $comment->id], 201);
    }
}
