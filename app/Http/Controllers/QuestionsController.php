<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\QuestionRating;
use App\Models\UserQuestionRating;
use App\Models\Config;
use Illuminate\Support\Facades\Auth;

class QuestionsController extends Controller
{
    public function getQuestions(Request $request)
    {
        
        $query = Question::with('user')->withCount('answers')->with('ratings')->with('topic')
        ->with(["user_question" => function($q){
            $q->where('user_question_ratings.user_id',Auth::id());
        }]);
        if($request->topic!=0){
            $query->where('topic_id',$request->topic);
        }
        if($request->sort!=''){
            if($request->sort=='new'){
                $query->orderBy('created_at','DESC');
            }
            if($request->sort=='hot'){
                // $query->orderBy('headline','DESC'); total/(max(abs(up - down) , 1 )
                $query->leftJoin('question_ratings','question_ratings.question_id','questions.id')->orderByRaw('(question_ratings.likes - question_ratings.dislikes) DESC');
            }
            if($request->sort=='controversial'){
                $query->leftJoin('question_ratings','question_ratings.question_id','questions.id')->orderByRaw('((question_ratings.likes + question_ratings.dislikes)/(abs(question_ratings.likes - question_ratings.dislikes))) DESC');
            }
        }else{
            $query->orderBy('created_at','DESC');
        }
        $data=$query->get();
        return $data;
    }

    public function getQuestion(Request $request)
    {
        
        $query = Question::with('user')->withCount('answers')->with('ratings')->with('topic')
        ->with(["user_question" => function($q){
            $q->where('user_question_ratings.user_id',Auth::id());
        }])->where('id',$request->question_id['id']);
        
        $data=$query->first();
        return $data;
    }

    public function getMyQuestions(Request $request)
    {
        $data = Question::with('user')->withCount('answers')->with('ratings')->with('topic')
        ->with(["user_question" => function($q){
            $q->where('user_question_ratings.user_id',Auth::id());
        }])->where('user_id', Auth::id())->get();
        return $data;
    }

    public function getLimit(Request $request)
    {
        $data = Config::where('user_id',Auth::id())->first();
        $data = $data["number_of_questions"];
        return $data;
    }

    public function postQuestion(Request $request)
    {
        $question = new Question;
        $question->user_id = Auth::id();
        $question->question = $request->question;
        $question->headline = $request->headline;
        $question->topic_id = $request->selectedTopic;
        $question->save();

        $questionRating = new QuestionRating;
        $questionRating->question_id = $question->id;
        $questionRating->likes = 0;
        $questionRating->dislikes = 0;
        $questionRating->save();
    }
    public function like(Request $request)
    {
        $questionRating = QuestionRating::where('question_id',$request->id)->firstOrFail();
        
        $type = $request->type;
        $currentLikes = $questionRating->likes;
        $currentDislikes= $questionRating->dislikes;
        if($type=="like_dislike"){
            $questionRating->likes = $currentLikes + 1;
            $questionRating->dislikes = $currentDislikes - 1;
            UserQuestionRating::updateOrCreate(
                ['question_id' => $request->id, 'user_id' => Auth::id()],
                ['like_dislike' => 1]
            );
        }else if($type=="like_subtract"){
            $questionRating->likes = $currentLikes - 1;
            UserQuestionRating::where('question_id', $request->id)->where('user_id', Auth::id())->delete();
        }
        else if($type=="like_add"){
            $questionRating->likes = $currentLikes + 1;
            UserQuestionRating::updateOrCreate(
                ['question_id' => $request->id, 'user_id' => Auth::id()],
                ['like_dislike' => 1]
            );
        }
        $questionRating->save();
        
    }
    public function dislike(Request $request)
    {
        
        $questionRating = QuestionRating::where('question_id',$request->id)->firstOrFail();
        $type = $request->type;
        $currentLikes = $questionRating->likes;
        $currentDislikes= $questionRating->dislikes;
        if($type=="like_dislike"){
            $questionRating->likes = $currentLikes -1;
            $questionRating->dislikes = $currentDislikes +1;
            UserQuestionRating::updateOrCreate(
                ['question_id' => $request->id, 'user_id' => Auth::id()],
                ['like_dislike' => 0]
            );
        }else if($type=="dislike_subtract"){
            $questionRating->dislikes = $currentDislikes - 1;
            UserQuestionRating::where('question_id', $request->id)->where('user_id', Auth::id())->delete();
        }
        else if($type=="dislike_add"){
            $questionRating->dislikes = $currentDislikes + 1;
            UserQuestionRating::updateOrCreate(
                ['question_id' => $request->id, 'user_id' => Auth::id()],
                ['like_dislike' => 0]
            );
        }
        $questionRating->save();
       
    }
}
