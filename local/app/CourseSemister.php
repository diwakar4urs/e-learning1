<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseSemister extends Model
{
    protected $table="coursesemisters";
    protected $fillable = ["course_id","year","total_semisters"];


    public function course()
    {
    	return belongsTo('App\Course');
    }

    /**
     * Get the list of no. of semisters present in selected course and selected year
     * @param  [type] $courseId [description]
     * @param  [type] $year     [description]
     * @return [type]           Course-Semister row 
     */
    public static function getCourseYearSemisters($courseId, $year)
    {
    	return CourseSemister::where('course_id', '=', $courseId)
    					->where('year', '=', $year)
    					->first();
    }
}
