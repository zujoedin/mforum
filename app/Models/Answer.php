<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;
    protected $casts = [
        'created_at'  => 'date:d/m/Y h:i',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function ratings()
    {
        return $this->hasMany(AnswerRating::class,'answer_id');
    }

    public function user_answer()
    {
        return $this->hasMany(UserAnswerRating::class,'answer_id');
    }
}
