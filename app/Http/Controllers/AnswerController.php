<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Answer;
use App\Models\Question;
use App\Models\AnswerRating;
use App\Models\UserAnswerRating;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class AnswerController extends Controller
{
    public function getAnswers(Request $request)
    {   
        
        $data = Answer::with('user')->with('ratings')
        ->with(["user_answer" => function($q){
            $q->where('user_answer_ratings.user_id',Auth::id());
        }])->where('question_id', $request->question_id['id'])->get();
        return $data;
    }

    public function postAnswer(Request $request)
    {
        $question_id = $request->question_id['id'];
        $answer = new Answer;
        $answer->user_id = Auth::id();
        $answer->question_id = $question_id;
        $answer->answer = $request->answer;
        $answer->save();

        $answerRating = new AnswerRating;
        $answerRating->answer_id = $answer->id;
        $answerRating->likes = 0;
        $answerRating->dislikes = 0;
        $answerRating->save();

        $question = Question::find($question_id);
        $user_question_id = $question->user_id;
        $notification = new Notification;
        $notification->answer_id = $answer->id;
        $notification->question_id = $question_id;
        $notification->user_id = $user_question_id;
        $notification->read = 0;
        $notification->save();
    }

    public function like(Request $request)
    {   
        
        $answerRating = AnswerRating::where('answer_id',$request->id)->firstOrFail();
        
        $type = $request->type;
        $currentLikes = $answerRating->likes;
        $currentDislikes= $answerRating->dislikes;
        if($type=="like_dislike"){
            $answerRating->likes = $currentLikes + 1;
            $answerRating->dislikes = $currentDislikes - 1;
            UserAnswerRating::updateOrCreate(
                ['answer_id' => $request->id, 'user_id' => Auth::id()],
                ['like_dislike' => 1]
            );
        }else if($type=="like_subtract"){
            $answerRating->likes = $currentLikes - 1;
            UserAnswerRating::where('answer_id', $request->id)->where('user_id', Auth::id())->delete();
        }
        else if($type=="like_add"){
            $answerRating->likes = $currentLikes + 1;
            UserAnswerRating::updateOrCreate(
                ['answer_id' => $request->id, 'user_id' => Auth::id()],
                ['like_dislike' => 1]
            );
        }
        $answerRating->save();
        
    }
    public function dislike(Request $request)
    {
        
        $answerRating = AnswerRating::where('answer_id',$request->id)->firstOrFail();
        $type = $request->type;
        $currentLikes = $answerRating->likes;
        $currentDislikes= $answerRating->dislikes;
        if($type=="like_dislike"){
            $answerRating->likes = $currentLikes -1;
            $answerRating->dislikes = $currentDislikes +1;
            UserAnswerRating::updateOrCreate(
                ['answer_id' => $request->id, 'user_id' => Auth::id()],
                ['like_dislike' => 0]
            );
        }else if($type=="dislike_subtract"){
            $answerRating->dislikes = $currentDislikes - 1;
            UserAnswerRating::where('answer_id', $request->id)->where('user_id', Auth::id())->delete();
        }
        else if($type=="dislike_add"){
            $answerRating->dislikes = $currentDislikes + 1;
            UserAnswerRating::updateOrCreate(
                ['answer_id' => $request->id, 'user_id' => Auth::id()],
                ['like_dislike' => 0]
            );
        }
        $answerRating->save();
       
    }
}
