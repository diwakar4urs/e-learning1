<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseSubject extends Model
{
    protected $table = 'course_subject';

    public static function getCourseSavedSubjects($academicId, $courseId, $year, $semister = 0)
    {
    	return CourseSubject::join('subjects', 'subjects.id','=','course_subject.subject_id')

                        ->where('course_id', '=', $courseId)
    					->where('year', '=', $year)
    					 
                        ->where('academic_id', '=', $academicId)
    					->where('semister', '=', $semister)
    					->get();
    }

    public static function isStaffAllocatedToCourse($staff_id)
    {
        return CourseSubject::where('staff_id','=',$staff_id)->count();
    }
}
