<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Auth;
class LessionPlan extends Model
{
    protected $table = 'lessionplans';

    /**
     * This method will return the detailed report for topics
     * which are completed from total available topics
     * It also returns the status in %
     * @param  [type] $subject_id [description]
     * @return [type]             [description]
     */
    public function getSubjectCompletedStatus($subject_id, $user_id, $course_subject_id)
    {
      //Get the Topics count with the given subject id
      $total_topics = Topic::where('subject_id', '=', $subject_id)
                                 ->where('parent_id','!=',0)
                                 ->count();
      $completed_topics = LessionPlan::join('course_subject',
                          'course_subject.id', '=', 'course_subject_id')
                        ->where('academic_id','=',getDefaultAcademicId()) 
                        ->where('subject_id','=',$subject_id) 
                        ->where('staff_id', '=', $user_id)
                        ->where('lessionplans.is_completed', '=', 1)
                        ->where('course_subject.id', '=', $course_subject_id)
                        ->count();
        $percent_completed = 0;
        if($total_topics)
          $percent_completed = ($completed_topics*100)/$total_topics;

        $data['total_topics'] = $total_topics;
        $data['completed_topics'] = $completed_topics;
        $data['percent_completed'] = $percent_completed;
        return (object)$data;


    }

     /**
     * This method returns the allocated subjects for 
     * specific staff with respective to the current academic year
     * @param  integer $user_id [description]
     * @param  integer $limit   [description]
     * @param  string  $orderBy [description]
     * @return [type]           [description]
     */
    public static function getSubjects($user_id=0, $limit=20, 
      $orderBy='asc' )
    {
      if(!$user_id)
        $user_id = Auth::user()->id;

      $current_academic_id = getDefaultAcademicId();
        $subjects = [];
      $subjects = CourseSubject::join('subjects', 'subjects.id','=','course_subject.subject_id')
      ->join('courses','courses.id','=','course_subject.course_id')
      ->where('staff_id','=',$user_id)
      ->where('academic_id','=',$current_academic_id)

      ->select(['course_subject.id as id','course_subject.slug as slug', 'subject_title', 'course_title', 'year', 'semister', 'subject_id','staff_id','course_dueration'])
       ->limit($limit);
       if($orderBy=='rand')
        $subjects = $subjects->inRandomOrder('year');
      else
       $subjects = $subjects->orderBy('year', $orderBy)->orderBy('semister', $orderBy);
      return $subjects->get();
    }
}
