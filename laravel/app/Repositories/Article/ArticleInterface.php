<?php

namespace App\Repositories\Article;

use App\Models\Article;
use Illuminate\Support\Collection;

interface ArticleInterface
{
    public function all($article): Collection;

    public function trashedArticle($article): Collection;

    public function show($article, $id): Collection;

    public function create($article, $request): Article;

    public function update($article, $request, $id): bool;

    public function destroy($article, $id): bool;
}
