<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreArticleRequest;
use App\Models\Article;
use App\Http\Resources\Article\IndexArticleResource;
use App\Http\Resources\Article\ShowArticleResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ArticlesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index(): JsonResponse
    {
        $articles = Article::with('comments')->get();

        Log::info('Articles all get', ['$articles' => $articles]);

        return response()->json([
            'articles' => IndexArticleResource::collection($articles)
        ], 200);
    }

    public function softDeleteIndex()
    {
        $articles = Article::withTrashed()->get();

        return response()->json([
            'softDeleteArticles' => $articles
        ], 201);
    }

    public function store(StoreArticleRequest $request, Article $article)
    {
        DB::beginTransaction();
        try {
            $new_article = $article->articleStore($request);

            DB::commit();

            return response()->json([
                'status_code'=> 201,
                'message' => 'success article post',
                'article' => $new_article,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info($e);
            throw $e;
        }
    }

    public function show(Article $article)
    {
        // dd('test');
        try {
            // dd($article->id);
            $article = Article::where('id', $article->id)->with('comments')->get();
            throw new \Exception('log test');
        } catch (\Exception $e) {
            Log::info($e);
            throw $e;
        }
    }

    public function update(StoreArticleRequest $request, Article $article)
    {
        try {
            DB::beginTransaction();
            $article->update($request->all());
           DB::commit();

            return response()->json([
                'message' => 'success article update',
                'article' => $article,
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            $e->getMessage();
        }
    }

    public function destroy(Article $article)
    {
        DB::beginTransaction();
        try {
            $article->delete();
            DB::commit();
    
            return response()->json([
                'status' => true,
                'message' => "Post Deleted successfully!",
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
