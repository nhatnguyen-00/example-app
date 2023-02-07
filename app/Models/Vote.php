<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;

    protected $table = 'votes';

    protected $fillable = [
        'user_id',
        'article_id',
        'value',
    ];

    const UPVOTE = 1;
    const DOWNVOTE = -1;
    const DEFAULT_VOTE = 0;
}
