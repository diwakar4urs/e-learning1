 

 $user->roles()->attach($user->role_id);

  $student = new App\Student();
          $student->admission_no  = $student->preparestudentID($user->id);
          $student->first_name    = $user->name;
          $student->user_id       = $user->id;
          


           $student->date_of_join            = $date_of_join;
           $student->academic_id             = $academic_id;
            
            $student->roll_no = $student->prepareRollNo($user->slug, $academic_id, $course_parent_id, $course_id);
            $student->current_year             = $year
            $student->current_semister         = $semister;
            $student->course_parent_id         = $course_parent_id;
            $student->course_id                = $course_id;

            $student->save();

            $promotionObject                      = new App\StudentPromotion();
            $promotionObject->user_id             =  $student->user_id;
            $promotionObject->student_id          =  $student->id;
            $promotionObject->type                =  'admission';
            $promotionObject->from_academic_id    =  $student->academic_id;
            $promotionObject->from_course_parent_id  =  $student->course_parent_id;
            $promotionObject->from_course_id      =  $student->course_id;
            $promotionObject->to_year             =  $student->current_year ;
            $promotionObject->to_semister         =  $student->current_semister;
            $promotionObject->record_updated_by   =  1;

            $promotionObject->save();

             $student->previous_highest_qualification
        									= $request->previous_highest_qualification;
        	$student->previous_highest_qualification_percentage   
        									= $request->previous_highest_qualification_percentage;
        	$student->year_passing   			= $request->year_passing;
        	$student->previous_institute_name   = $request->previous_institute_name;
        	$student->previous_institute_address= $request->previous_institute_address;
        	$student->record_updated_by   =  Auth::user()->id;
       
	        $student->save();

	         $student->first_name      = $request->first_name;
        $student->middle_name     = $request->middle_name;
        $student->last_name       = $request->last_name;
        $student->gender          = $request->gender;
        $student->blood_group     = $request->blood_group;
        $student->date_of_birth   = $request->date_of_birth;    
        $student->fathers_name    = $request->fathers_name;    
        $student->mothers_name    = $request->mothers_name;    
        $student->nationality     = $request->nationality;    
        $student->mother_tongue   = $request->mother_tongue;    
        $student->category_id  	  = $request->category_id;    
        $student->religion_id  	  = $request->religion_id;    
        $student->save();

         $student->address_lane1   = $request->address_lane1;
        $student->address_lane2   = $request->address_lane2;
        $student->city            = $request->city;    
        $student->state           = $request->state;    
        $student->country         = $request->country;    
        $student->zipcode         = $request->zipcode;    
        $student->mobile          = $request->mobile;    
        $student->home_phone      = $request->home_phone;    
        $student->save();

