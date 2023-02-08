<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Article;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bookmark extends Model
{
    use HasFactory;

    protected $table = 'book_marks';

    protected $fillable = [
        'user_id',
        'article_id',
        'status',
    ];

    const BOOKMARK_STATUS = 1;
    const UN_BOOKMARK_STATUS = 0;

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class, 'article_id');
    }
}
