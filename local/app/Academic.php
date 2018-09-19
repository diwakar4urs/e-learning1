<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Academic extends Model
{
    public function courses()
    {
    	return $this->belongsToMany('App\Course');
    }

    public function academicCourses()
    {
         return $this->hasMany('App\AcademicCourse', 'academic_id');
         
    }

    /**
     * Fetches the list of courses available in academic_course table and returns as json array
     * @param  [int] $academicId [academic ID]
     * @return [json list]             [list]
     */
    public function getCourseList($academicId)
    {
         $academic_title = '';
        if($academicId)
        {
            $academic_record = DB::table('academics')->where('id', '=', $academicId)->get();
            if(count($academic_record))
            {                
                return DB::table('academics')->where('academic_year_title', '=', $academic_record[0]->academic_year_title)->get(); 
            }

        }

        return DB::table('academics')->get();

    }

    /**
     * Fetches the course name available in academic_course table and returns a string
     * @param  [int] $academicId [academic ID]
     * @return [string]             [string]
     */
    public function getCourseName()
    {
         return $this->hasOne('App/Course');
    }

}
