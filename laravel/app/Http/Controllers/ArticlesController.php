<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreArticleRequest;
use App\Models\Article;
use App\Http\Resources\ArticleResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ArticlesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index(): JsonResponse
    {
        $articles = Article::with('comments')->get();

        return response()->json([
            'status_code' => 201,
            'articles' => ArticleResource::collection($articles)
        ]);
    }

    public function softDeleteIndex()
    {
        $articles = Article::withTrashed()->get();

        return response()->json([
            'status_code' => 200,
            'softDeleteArticles' => $articles
        ]);
    }

    public function store(StoreArticleRequest $request, Article $article)
    {
        try {
            $new_article = $article->articleStore($request);

            return response()->json([
                'status_code'=> 201,
                'message' => 'success article post',
                'article' => $new_article,
            ]);
        } catch (\Exception $e) {
            $e->getMessage();
        }
    }

    public function update(StoreArticleRequest $request, Article $article)
    {
        try {
            $article->update($request->all());

            return response()->json([
                'status_code'=> 201,
                'message' => 'success article update',
                'article' => $article,
            ]);
        } catch (\Exception $e) {
            $e->getMessage();
        }
    }

    public function destroy(Article $article)
    {
        $article->delete();

        return response()->json([
            'status' => true,
            'message' => "Post Deleted successfully!",
        ], 200);
    }
}
