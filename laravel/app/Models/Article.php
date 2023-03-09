<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Article extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['title', 'description'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function articleStore($request)
    {
        $article = new Article;

        $article->title = $request->title;
        $article->description = $request->description;
        $article->user_id = Auth::id();
        $article->save();

        return $article;
    }
}
