<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AcademicCourse extends Model
{
    protected $table = 'academic_course';

    public function semisters()
    {
    	return $this->hasMany('App\CourseSemister','course_id')->get();
    }
}	
