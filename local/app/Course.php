<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Semister;
use DB;

class Course extends Model
{

    /**
     * Get the semisters for the selected course
     * @return [type] [description]
     */
    public function semisters()
    {
    	return $this->hasMany('App\CourseSemister');
    }

    
    public function allotedFeeCategories($academicCourseId)
    {
        if($academicCourseId)
        {
            return DB::table('feecategories_academiccourses')
            ->where('academic_course_id', '=',$academicCourseId)
            ->get();
        }
        return array();
    }


    public static function getCourses($parentId = 0)
    {
        return Course::where('parent_id','=', $parentId)->get();
    }

    public function getCourseDueration($course_id)
    {
        return Course::where('id','=',$course_id)->select('course_dueration')->get();
    }

    public static function getCourseRecord($courseId )
    {
        return Course::where('id','=', $courseId)->get()->first();
    }

}
