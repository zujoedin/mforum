<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\QuestionTopic;

class AddTopicsSeedsToTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('topics', function (Blueprint $table) {
            $topics = [
                [
                    'topic' => 'Arts',    
                ],
                [
                    'topic' => 'Culture',    
                ],
                [
                    'topic' => 'History',    
                ],
                [
                    'topic' => 'Geography',    
                ],
                [
                    'topic' => 'Sports',    
                ],
                [
                    'topic' => 'Health',    
                ],
                [
                    'topic' => 'Religion',    
                ],        
    
            ];
    
            foreach ($topics as $topic) {
                $newTopic = QuestionTopic::create($topic);
                $newTopic->save();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('topics', function (Blueprint $table) {
            //
        });
    }
}
