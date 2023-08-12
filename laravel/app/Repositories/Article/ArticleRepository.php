<?php

namespace App\Repositories\Article;

use App\Repositories\Article\ArticleInterface;
use Illuminate\Support\Collection;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;

class ArticleRepository implements ArticleInterface
{
    public function all($article): Collection
    {
        return $article->with('comments')->get();
    }

    public function trashedArticle($article): Collection
    {
        return Article::withTrashed()->get();
    }

    public function show($article, $id): Collection
    {
        // return $article->where('id', $id)->with('comments')->get();
        // $return = $article->where('id', $id)->with('comments')->get();
        $return = $article->find($id);
        dd($return);
    }

    public function create($article, $request): Article
    {
        $return = $article->create([
        // return $article->create([
            "title" => $request->title,
            "content" => $request->content,
            "user_id" => Auth::id(),
        ]);
        dd($return);
    }

    public function update($article, $request, $id): bool
    {
        return $article->find($id)->update($request->all());
    }

    public function destroy($article, $id): bool
    {
        return $article->find($id)->delete();
    }
}
