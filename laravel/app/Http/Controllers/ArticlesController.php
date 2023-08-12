<?php

namespace App\Http\Controllers;

use App\Http\Resources\Article\StoreArticleResource;
use App\Repositories\Article\ArticleInterface;
use App\Repositories\Article\ArticleRepository;
use Illuminate\Http\Request;
use App\Http\Requests\Article\StoreArticleRequest;
use App\Models\Article;
use App\Http\Resources\Article\IndexArticleResource;
use App\Http\Resources\Article\ShowArticleResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ArticlesController extends Controller
{
    private $article;
    private $articleRepository;
    public function __construct(Article $article, ArticleRepository $articleRepository)
    {
        $this->middleware('auth:sanctum', ['expect' => [ 'show', 'create' ]]);
        $this->article = $article;
        $this->articleRepository = $articleRepository;
    }

    public function index()
    // public function index(Article $article, ArticleRepository $articleRepository)
    {
        $articles = $this->articleRepository->all($this->article);
        // $articles = $articleInterface->all($article);
        // $articles = $articleRepository->all($article);
        // $articles = Article::with('comments')->get();

        Log::info('Articles all get', ['$articles' => $articles]);

        return response()->json([
            'articles' => IndexArticleResource::collection($articles)
        ], 200);
    }

    public function softDeleteIndex()
    {
        $articles = $this->articleRepository->trashedArticle($this->article);
        // $articles = Article::withTrashed()->get();

        return response()->json([
            'softDeleteArticles' => $articles
        ], 201);
    }

    public function store(StoreArticleRequest $request, Article $article)
    {
        try {
            DB::beginTransaction();
            $article = $this->articleRepository->create($this->article, $request);
            $article = collect([$article]);

            DB::commit();

            return response()->json([
                'message' => 'success article post',
                'article' => StoreArticleResource::collection($article),
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info($e);
            throw $e;
        }
    }

    public function show($id)
    {
        try {
            $article = $this->articleRepository->show($this->article, $id);
            return response()->json([
                'article' => ShowArticleResource::collection($article)
            ]);
        } catch (\Exception $e) {
            Log::info($e);
            throw $e;
        }
    }

    public function update(StoreArticleRequest $request, string $id)
    {
        try {
            DB::beginTransaction();
            $article = $this->articleRepository->update($this->article, $request, $id);

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

    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();
            $article = $this->articleRepository->destroy($this->article, $id);
            DB::commit();

            return response()->json([
                'message' => "Post Deleted success",
                "article" => $article
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
