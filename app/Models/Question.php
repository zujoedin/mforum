<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $casts = [
        'created_at'  => 'date:d/m/Y h:i',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function ratings()
    {
        return $this->hasMany(QuestionRating::class,'question_id');
    }

    public function topic()
    {
        return $this->belongsTo(QuestionTopic::class,'topic_id');
    }

    public function user_question()
    {
        return $this->hasMany(UserQuestionRating::class,'question_id');
    }
}
