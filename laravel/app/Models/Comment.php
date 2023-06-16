<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['content', 'user_id', 'article_id'];
    // protected $fillable = ['content', 'article_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    public function commentStore($request)
    {
        $comment = self::create([
            "content" => $request->content,
            "user_id" => Auth::id(),
            "article_id" => $request->article_id,
        ]);
        // dd($comment);
        return $comment;
    }
}
