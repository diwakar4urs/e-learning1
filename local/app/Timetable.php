<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
class Timetable extends Model
{
    protected $table = 'timetable';

    /**
     * $code contains the elements in the below format saperated by _
     * 0-academic_id, 1-course_id, 2-current_year, 3-day, 
     * 4-timingset_id, 5-timingset_map_id, 6-timingset_details_id(period_id)
     * @var [type]
     */
     public function decodeObject($code)
     {

         $index_academic_id = 0;
        $index_course_id = 1;
        $index_year = 2;
        $index_semester = 3;
        $index_day = 4;
        $index_timingset_id = 5;
        $index_timingset_map_id = 6;
        $index_period_id = 7;

        $elements               = explode('_',$code);
        $data['academic_id']    = $elements[$index_academic_id];
        $data['course_id']      = $elements[$index_course_id];
        $data['year']           = $elements[$index_year];
        $data['semister']       = $elements[$index_semester];
        $data['day']            = $elements[$index_day];
        $data['timingset_id']   = $elements[$index_timingset_id];
        $data['timingset_map_id'] = $elements[$index_timingset_map_id];
        $data['timingset_details_id'] = $elements[$index_period_id];

        return $data;
     }

     public static function getDayClasses($user_id=0, $day_no = -1, $limit=10)
     {
         $academic_id = getDefaultAcademicId();

         if($day_no==-1)
            $day_no = date('N');
        if(!$user_id)
            $user_id = Auth::user()->id;


        return Timetable::join('subjects', 'subjects.id','=','timetable.subject_id')
                        ->join('courses','courses.id','=', 'timetable.course_id')
                        ->join('timingsetdetails','timingsetdetails.id', 
                            '=', 'timetable.timingset_details_id')
                        ->where('academic_id','=',$academic_id)
                        ->where('user_id', '=', $user_id)
                        ->where('day', '=', $day_no)
                        ->select(['subjects.id as subject_id', 'subjects.subject_title','course_title','start_time','end_time'])
                        ->limit($limit)
                        ->orderBy('start_time')
                        ->get();

     }

      public static function getStudentDayClasses($user_id=0, $day_no = -1, $limit=10)
     {
         $academic_id = getDefaultAcademicId();
         
         
         if($day_no==-1)
            $day_no = date('N');
        if(!$user_id)
            $user_id = Auth::user()->id;

         $student_record = Student::where('user_id', '=', $user_id)->first();

        return Timetable::join('subjects', 'subjects.id','=','timetable.subject_id')
                        ->join('courses','courses.id','=', 'timetable.course_id')
                        ->join('timingsetdetails','timingsetdetails.id', 
                            '=', 'timetable.timingset_details_id')
                        ->where('academic_id','=',$academic_id)
                        ->where('course_id', '=', $student_record->course_id)
                        ->where('year', '=', $student_record->current_year)
                        ->where('semister', '=', $student_record->current_semister)
                        ->where('day', '=', $day_no)
                        ->select(['subjects.id as subject_id', 'subjects.subject_title','course_title','start_time','end_time'])
                        ->limit($limit)
                        ->orderBy('start_time')
                        ->get();


     }
}
