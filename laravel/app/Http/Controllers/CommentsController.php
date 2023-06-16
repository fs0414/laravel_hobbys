<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Resources\CommentResource;

class CommentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index()
    {
        $comments = Comment::all();

        return response()->json([
            'status_code' => 200,
            'comments' => CommentResource::collection($comments)
        ]);
    }

    // public function store(StoreCommentRequest $request, Comment $comment)
    public function store(Request $request, Comment $comment)
    // public function store(Comment $comment)
    {
        try {
            $new_comment = $comment->commentStore($request);

            return response()->json([
                'status_code' => 201,
                'new_comment' => $new_comment
            ]);
        } catch (\Exception $e) {
            $e->getMessage();
        }
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();

        return response()->json([
            'status' => 201,
            'message' => 'comment delete success'
        ]);
    }
}
