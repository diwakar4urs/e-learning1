<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuizCategory extends Model
{
    protected $table = "quizcategories";

   
    public static function getRecordWithSlug($slug)
    {
        return QuizCategory::where('slug', '=', $slug)->first();
    }

    /**
     * Lists the list of quizes related to the selected category
     * @return [type] [description]
     */
    public function quizzes()
    {        
        return $this->getQuizzes()
        ->where('start_date','<=',date('Y-m-d H:i:s'))
        ->where('end_date','>=',date('Y-m-d H:i:s'))
        ->where('total_questions','>','0')
        ->where('applicable_to_specific', '=', 0)
        ->get();

        
    }

    public function getQuizzes()
    {
        return $this->hasMany('App\Quiz', 'category_id');

    }
}
