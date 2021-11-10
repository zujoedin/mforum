<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserQuestionRating extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id',
        'user_id',
        'like_dislike',
    ];
}
