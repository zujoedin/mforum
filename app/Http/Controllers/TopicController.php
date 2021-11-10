<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QuestionTopic;

class TopicController extends Controller
{
    public function getTopics(Request $request)
    {
        $data = QuestionTopic::get();
        return $data;
    }
}
