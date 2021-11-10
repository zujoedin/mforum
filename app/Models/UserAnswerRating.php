<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAnswerRating extends Model
{
    use HasFactory;
    protected $fillable = [
        'answer_id',
        'user_id',
        'like_dislike',
    ];
}
