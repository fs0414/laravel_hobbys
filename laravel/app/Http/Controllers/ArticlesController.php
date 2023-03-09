<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleRequest;
use Illuminate\Http\Request;
use App\Models\Article;

class ArticlesController extends Controller
{
    public function __construct(){
        $this->middleware('auth:sanctum');
    }
    public function index()
    {
        // $articles = Article::all();

        $softDeleteArticle = Article::withTrashed()->get();

        return response()->json([
            'status_code' => 201,
            // 'articles' => $articles,
            'softDeletesArticle' => $softDeleteArticle
        ]);
    }

    public function store(StoreArticleRequest $request, Article $article)
    {
        try {
            $article_result = $article->articleStore($request);

            return response()->json([
                'status_code'=> 201,
                'message' => 'success article post',
                'article' => $article_result,
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
