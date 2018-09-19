<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class StudentAttendance extends Model
{
    protected $table = 'studentattendance';
    
    public function getAttendanceCount($type='P', $academic_id = 0, $course_id = 0, $year=1, $semester=0)
    {
        if(!$academic_id)
            $academic_id = getDefaultAcademicId();

        if(!$course_id)
            $course_id=1;
        $attendance_query = StudentAttendance::
                        where('student_id', '=', $this->student_id)
                        ->where('academic_id', $academic_id)
                        ->where('course_id', $course_id)
                        ->where('year', $year)
                        ->where('semester', $semester);
        
            $attendance_query = $attendance_query->where('attendance_code', '=', $type);
        return $attendance_query->sum('total_class');
                        

    }
}
