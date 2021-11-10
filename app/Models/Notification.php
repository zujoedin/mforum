<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    public function question()
    {
        return $this->belongsTo(Question::class,'question_id');
    }

    public function answer()
    {
        return $this->belongsTo(Answer::class,'answer_id');
    }
}
