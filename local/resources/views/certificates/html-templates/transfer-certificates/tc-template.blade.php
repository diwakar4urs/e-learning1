<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>TC</title>
</head>

<body>

{!!Form::open(array('url'=> URL_ISSUE_CERTIFICATE_TC_DETAILS,'method'=>'POST','name'=>'formTC','target'=>'_blank'))!!} 

<input type="hidden" name="student_id" value="{{$student_data->id}}">
<input type="hidden" name="tc_id" value="{{$tc_no->id}}">
    

    <table cellpadding="0" cellspacing="0" border="0" bgcolor="#FFF" style="font-family: arial;font-size: 16px;color: #555; line-height: 18px; border-top: 1px solid #ccc;border-left: 1px solid #ccc;" align="center" width="800">
      <?php if(getSetting('print_header  ', 'transfer_certificate_settings')) { ?>
        <tr>
            <td colspan="2" style="border-bottom: 1px solid #ccc;border-right: 1px solid #ccc;">
                <table cellpadding="0" cellspacing="0" width="100%">

                <tr>
                    <td colspan="3">
                        <table width="100%">
                            <tr>
                                <td width="25%"></td>
                                <td align="center"><img src="{{IMAGE_PATH_SETTINGS.getSetting('site_logo', 'site_settings')}}" height="60" alt=""></td>

                                <?php if(getSetting('print_date  ', 'transfer_certificate_settings')) { ?>

                                  <td width="25%" align="right"><span style=" font-family:arial; color:#777">{{getPhrase('date')}}: 
             
                                       <b>{{date('d M Y')}}</b>
                                       </span></td>
                                       <?php }?>
                            </tr>
                        </table>
                    </td>
                </tr>
                    <tr>
                       
                         
                        <td align="center" style="padding:10px 15px;"> 
                            <h4 style="font-family: arial;font-size: 20px; margin-top: 0; color: #555; line-height: 24px; text-align: center;">{{getSetting('site_address','site_settings')}}</h4><hr><h2>Transfer Certificate</h2>
                            
                            <table cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td>
                                        <?php if(getSetting('print_reference_number  ', 'transfer_certificate_settings')) { ?>
                    
                            <strong>

                            {{getPhrase('serial_no:')}}

                            <input type="text" name="serial_no" value="{{$tc_no->reference_no}}" readonly="true">

                            </strong>
                            <?php } ?>
                                    </td>
                                    <td align="right">
                                        <strong>

                            {{getPhrase('Admission_no:')}}<input type="text" name="admission_no" value="{{$student_data->admission_no}}" readonly="true">
                            

                             </strong>
                                    </td>
                                </tr>
                            </table>


                             </td>
                       

                     </tr>

                </table>    
            </td>
        </tr>
         <?php } 

         ?>
            

          <?php if(getSetting('name_of_student', 'transfer_certificate_fields')) { ?>
        <tr>
            <td style="padding: 10px; border-bottom: 1px solid #ccc;border-right: 1px solid #ccc;" width="50%"><strong>{{getPhrase('name_of_the_pupil')}}</strong> </td>
            <td style="padding: 10px; border-bottom: 1px solid #ccc;border-right: 1px solid #ccc;"><strong><input type="text" name="student_name"  value="{{$student_data->first_name ?? 'NA'}} {{$student_data->last_name ?? 'NA'}}" readonly="true"></strong></td>
        </tr>
        <?php } ?>

       <?php  if(getSetting('father_guardian_name', 'transfer_certificate_fields')) { ?>
        <tr>
            <td style="padding: 10px; border-bottom: 1px solid #ccc;border-right: 1px solid #ccc;" width="50%"><strong>{{getPhrase('father_/_guardian Name')}}</strong> </td>
            <td style="padding: 10px; border-bottom: 1px solid #ccc;border-right: 1px solid #ccc;"><strong><input type="text" name="fathername"  value="{{$student_data->fathers_name ?? 'NA'}}" readonly="true"></strong></td>
        </tr>
        <?php } ?>

         <?php if(getSetting('mother_name', 'transfer_certificate_fields')) { ?>
        <tr>
            <td style="padding: 10px; border-bottom: 1px solid #ccc;border-right: 1px solid #ccc;" width="50%"><strong>{{getPhrase('mother_name')}}</strong> </td>
            <td style="padding: 10px; border-bottom: 1px solid #ccc;border-right: 1px solid #ccc;"><strong><input type="text" name="mothername"  value="{{$student_data->mothers_name ?? 'NA'}}" readonly="true"></strong></td>
        </tr>
        <?php } ?>

        <?php if(getSetting('nationality', 'transfer_certificate_fields')) { ?>
        <tr>
            <td style="padding: 10px; border-bottom: 1px solid #ccc;border-right: 1px solid #ccc;" width="50%"><strong>{{getPhrase('nationality')}}</strong> </td>
            <td style="padding: 10px; border-bottom: 1px solid #ccc;border-right: 1px solid #ccc;"><strong><input type="text" name="nation"  value="{{$country_name ?? 'NA'}}" readonly="true"></strong></td>
        </tr>
        <?php } ?>

        <?php if(getSetting('candidate_caste', 'transfer_certificate_fields'))  { ?>
        <tr>
            <td style="padding: 10px; border-bottom: 1px solid #ccc;border-right: 1px solid #ccc;" width="50%"><strong>{{getPhrase('candidate_belongs_to_schedule_caste_or_schedule_tribe')}}</strong> </td>
            <td style="padding: 10px; border-bottom: 1px solid #ccc;border-right: 1px solid #ccc;"><strong><input type="text" name="caste"  value="{{$categoryname->category_name ?? 'NA'}}" readonly="true"></strong></td>
        </tr>
        <?php } ?>
        @if($last_class_study)
        <?php if($last_class_study->course_dueration>1) { ?>

        <?php if(getSetting('date_of_admission_with_class ', 'transfer_certificate_fields')) { ?>
        <tr>
            <td style="padding: 10px; border-bottom: 1px solid #ccc;border-right: 1px solid #ccc;" width="50%"><strong>{{getPhrase('date_of_first_admission_in_the_school')}}</strong> </td>
            <td style="padding: 10px; border-bottom: 1px solid #ccc;border-right: 1px solid #ccc;"><strong><input type="text" name="joining_date"  value="{{$student_data->date_of_join ?? 'NA'}}" readonly="true"></strong></td>
        </tr>

        <?php }?>

         <?php if(getSetting('first_admission_in_the_school', 'transfer_certificate_fields')) {?>
        <tr>
            <td style="padding: 10px; border-bottom: 1px solid #ccc;border-right: 1px solid #ccc;" width="50%"><strong>{{getPhrase('first_admission_class_in_the_school_with_name')}}</strong> </td>
            <td style="padding: 10px; border-bottom: 1px solid #ccc;border-right: 1px solid #ccc;"><strong><input type="text" name="joining_class"  value="{{$joined_class_academicname->academic_year_title ?? 'NA'}} - {{$joined_class->course_title ?? 'NA'}} - {{$joined_classdetails->from_year ?? 'NA'}} - {{$joined_classdetails->from_semister ?? 'NA'}}" readonly="true"></strong></td>
        </tr>

        <?php } ?>

        <?php } ?>
        @endif
         @if($last_class_study)
         <?php if($last_class_study->course_dueration<=1) { ?>

        <?php if(getSetting('date_of_admission_with_class ', 'transfer_certificate_fields')) { ?>
        <tr>
            <td style="padding: 10px; border-bottom: 1px solid #ccc;border-right: 1px solid #ccc;" width="50%"><strong>{{getPhrase('date_of_first_admission_in_the_school_with_class')}}</strong> </td>
            <td style="padding: 10px; border-bottom: 1px solid #ccc;border-right: 1px solid #ccc;"><strong><input type="text" name="joining_date"  value="{{$student_data->date_of_join}}" readonly="true"></strong></td>
        </tr>
        <?php } ?>

        <?php if(getSetting('first_admission_in_the_school', 'transfer_certificate_fields')) {?>
        <tr>
            <td style="padding: 10px; border-bottom: 1px solid #ccc;border-right: 1px solid #ccc;" width="50%"><strong>{{getPhrase('first_admission_class_in_the_school_with_name')}}</strong> </td>
            <td style="padding: 10px; border-bottom: 1px solid #ccc;border-right: 1px solid #ccc;"><strong><input type="text" name="joining_class"  value="{{$joined_class_academicname->academic_year_title}} - {{$joined_class->course_title}}" readonly="true"></strong></td>
        </tr>

        <?php } ?>

        <?php } ?>
        @endif


        <?php if(getSetting('date_of_birth ', 'transfer_certificate_fields')) { ?>
        <tr>
            <td style="padding: 10px; border-bottom: 1px solid #ccc;border-right: 1px solid #ccc;" width="50%"><strong>{{getPhrase('date_of_birth_according_to_the_admission_register')}}</strong> </td>
            <td style="padding: 10px; border-bottom: 1px solid #ccc;border-right: 1px solid #ccc;"><strong><input type="text" name="date_of_birth"  value="{{$student_data->date_of_birth}}" readonly="true"></strong></td>
        </tr>
        <?php } ?>
         @if($last_class_study)
        <?php if($last_class_study->course_dueration>1) { ?>

        <?php if(getSetting('last_class_studied ', 'transfer_certificate_fields')) { ?>
        <tr>
            <td style="padding: 10px; border-bottom: 1px solid #ccc;border-right: 1px solid #ccc;" width="50%"><strong>{{getPhrase('class_in_which_the_last_studied_with_name')}}</strong> </td>
            <td style="padding: 10px; border-bottom: 1px solid #ccc;border-right: 1px solid #ccc;"><strong><input type="text" name="last_class_study" value="{{$last_study_academicname->academic_year_title}} - {{$last_class_study->course_title}} - {{$last_study_classdetails->from_year}} - {{$last_study_classdetails->from_semister}}" readonly="true"></strong></td>
        </tr>
        <?php } ?>

        <?php }?>
        

         <?php if($last_class_study->course_dueration<=1) { ?>

        <?php if(getSetting('last_class_studied ', 'transfer_certificate_fields')) { ?>
        <tr>
            <td style="padding: 10px; border-bottom: 1px solid #ccc;border-right: 1px solid #ccc;" width="50%"><strong>{{getPhrase('class_in_which_the_last_studied_with_name')}}</strong> </td>
            <td style="padding: 10px; border-bottom: 1px solid #ccc;border-right: 1px solid #ccc;"><strong><input type="text" name="last_class_study" value="{{$last_study_academicname->academic_year_title}} - {{$last_class_study->course_title}}" readonly="true"></strong></td>
        </tr>
        <?php } ?>

        <?php } ?>
        @endif
        <?php if(getSetting('last_taken_exam_and_result ', 'transfer_certificate_fields')) { ?>
        <tr>
            <td style="padding: 10px; border-bottom: 1px solid #ccc;border-right: 1px solid #ccc;" width="50%"><strong>{{getPhrase('school_/_board_annual_examination_last_taken_and_result')}}</strong> </td>
            <td style="padding: 10px; border-bottom: 1px solid #ccc;border-right: 1px solid #ccc;"><strong><input type="text" name="exam_details" ></strong></td>
        </tr>
        <?php } ?>

        <?php if(getSetting('whether_failed_if_once_twice_in_the_same_class ', 'transfer_certificate_fields')) { ?>
        <tr>
            <td style="padding: 10px; border-bottom: 1px solid #ccc;border-right: 1px solid #ccc;" width="50%"><strong>{{getPhrase('whether_failed,_if_once_/_twice_in_the_same_class')}}</strong> </td>
            <td style="padding: 10px; border-bottom: 1px solid #ccc;border-right: 1px solid #ccc;"><strong><input type="text" name="exam_status" ></strong></td>
        </tr>
        <?php } ?>

        <?php if(getSetting('promotion_class ', 'transfer_certificate_fields')) { ?>
        <tr>
            <td style="padding: 10px; border-bottom: 1px solid #ccc;border-right: 1px solid #ccc;" width="50%"><strong>{{getPhrase('whether_qualified_for_promotion_to_higer_class_if_so,_to_which_class')}}</strong> </td>
            <td style="padding: 10px; border-bottom: 1px solid #ccc;border-right: 1px solid #ccc;"><strong><input type="text" name="promotion_class"></strong></td>
        </tr>
        <?php } ?>

        <?php if(getSetting('total_working_days ', 'transfer_certificate_fields')) { ?>
        <tr>
            <td style="padding: 10px; border-bottom: 1px solid #ccc;border-right: 1px solid #ccc;" width="50%"><strong>{{getPhrase('total_number_no.of_working_days')}}</strong> </td>
            <td style="padding: 10px; border-bottom: 1px solid #ccc;border-right: 1px solid #ccc;"><strong><input type="text" name="working_days"></strong></td>
        </tr>
        <?php } ?>

        <?php if(getSetting('total_present_days ', 'transfer_certificate_fields')) { ?>
        <tr>
            <td style="padding: 10px; border-bottom: 1px solid #ccc;border-right: 1px solid #ccc;" width="50%"><strong>{{getPhrase('total_number_no.of_present_days')}}</strong> </td>
            <td style="padding: 10px; border-bottom: 1px solid #ccc;border-right: 1px solid #ccc;"><strong><input type="text" name="present_days"></strong></td>
        </tr>
        <?php } ?>

        <?php if(getSetting('ncc_boy_scout_girls_guide ', 'transfer_certificate_fields')) { ?>
        <tr>
            <td style="padding: 10px; border-bottom: 1px solid #ccc;border-right: 1px solid #ccc;" width="50%"><strong>{{getPhrase('whether_nCC_cadet_/_boy_scout/_girls_guide')}}</strong> </td>
            <td style="padding: 10px; border-bottom: 1px solid #ccc;border-right: 1px solid #ccc;"><strong><input type="text" name="ncc"></strong></td>
        </tr>
        <?php } ?>

        <?php if(getSetting('games_played_or_extra_curricular_activities ', 'transfer_certificate_fields')) { ?>
         <tr>
            <td style="padding: 10px; border-bottom: 1px solid #ccc;border-right: 1px solid #ccc;" width="50%"><strong>{{getPhrase('games_played_or_extra-_curricular_activities')}}</strong> </td>
            <td style="padding: 10px; border-bottom: 1px solid #ccc;border-right: 1px solid #ccc;"><strong><input type="text" name="activities"></strong></td>
        </tr>
        <?php }?>

        <?php if(getSetting('general_conduct ', 'transfer_certificate_fields')) { ?>
        <tr>
            <td style="padding: 10px; border-bottom: 1px solid #ccc;border-right: 1px solid #ccc;" width="50%"><strong>{{getPhrase('general_conduct')}}</strong></td>
            <td style="padding: 10px; border-bottom: 1px solid #ccc;border-right: 1px solid #ccc;"><strong><input type="text" name="conduct"></strong></td>
        </tr>
        <?php } ?>

        <?php if(getSetting('date_of_apply ', 'transfer_certificate_fields')) { ?>
        <tr>
            <td style="padding: 10px; border-bottom: 1px solid #ccc;border-right: 1px solid #ccc;" width="50%"><strong>{{getPhrase('date_of_application_for_certificate')}}</strong> </td>
            <td style="padding: 10px; border-bottom: 1px solid #ccc;border-right: 1px solid #ccc;"><strong><input type="text" name="apply_date"></strong></td>
        </tr>
        <?php } ?>

        <?php if(getSetting('date_of_issue ', 'transfer_certificate_fields')) { ?>
        <tr>
            <td style="padding: 10px; border-bottom: 1px solid #ccc;border-right: 1px solid #ccc;" width="50%"><strong>{{getPhrase('date_of_issue_certificate')}}</strong> </td>
            <td style="padding: 10px; border-bottom: 1px solid #ccc;border-right: 1px solid #ccc;"><strong>{{date('d M Y')}}</strong></td>
        </tr>
        <?php } ?>
        <?php  if(getSetting('reason ', 'transfer_certificate_fields')) { ?>
        <tr>
            <td style="padding: 10px; border-bottom: 1px solid #ccc;border-right: 1px solid #ccc;" width="50%"><strong>{{getPhrase('reason_for_leaving_the_school')}}</strong> </td>
            <td style="padding: 10px; border-bottom: 1px solid #ccc;border-right: 1px solid #ccc;"><strong><input type="text" name="reason"></strong></td>
        </tr>
        <?php } ?>

        <?php if(getSetting('remarks ', 'transfer_certificate_fields')) { ?>
        <tr>
            <td style="padding: 10px; border-bottom: 1px solid #ccc;border-right: 1px solid #ccc;" width="50%"><strong>{{getPhrase('any_other_remarks')}}</strong> </td>
            <td style="padding: 10px; border-bottom: 1px solid #ccc;border-right: 1px solid #ccc;"><strong><input type="text" name="remarks"></strong></td>
        </tr>
        <?php } ?>

        <?php if(getSetting('print_footer  ', 'transfer_certificate_settings')) { ?>
        
        <tr>
            <td colspan="2" style="padding: 10px; border-bottom: 1px solid #ccc;border-right: 1px solid #ccc;">
                <table cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td>
                        <?php if(getSetting('show_left_side_sign   ', 'transfer_certificate_settings')) { ?>

                    <img src="{{IMAGE_PATH_SETTINGS.getSetting('left_sign_image', 'certificate')}}" height="60" alt="">
                    
                  <?php } ?> 
                    </td>
                    <td align="right">
                        <?php if(getSetting('show_right_side_sign   ', 'transfer_certificate_settings')) { ?> 

                         <img src="{{IMAGE_PATH_SETTINGS.getSetting('right_sign_image', 'certificate')}}" height="60" alt="">
                         

                         <?php  }?>
                    </td>
                </tr>
                    <tr>
                

                    <?php if(getSetting('show_left_side_name   ', 'transfer_certificate_settings')) { ?>       
                        <td  align="left" width="50%"  valign="bottom">
                           {{getSetting('left_sign_name','certificate')}}
                        </td>
                        <?php } ?>

                        

                         <?php if(getSetting('show_right_side_name   ', 'transfer_certificate_settings')) { ?>

                        <td  align="right" width="50%"  valign="bottom">
                           {{getSetting('right_sign_name','certificate')}}
                        </td>
                        
                        <?php  }?>

                    </tr>
                     <tr>
                

                    <?php if(getSetting('show_left_side_designation   ', 'transfer_certificate_settings')) { ?>       
                        <td  align="left" width="50%"  valign="bottom"s>
                            {{getSetting('left_sign_designation','certificate')}}
                        </td>
                        <?php } ?>

                        

                         <?php if(getSetting('show_right_side_designation   ', 'transfer_certificate_settings')) { ?>

                        <td  align="right" width="50%"  valign="bottom">
                            {{getSetting('right_sign_designation','certificate')}}
                        </td>
                        
                        <?php  }?>

                    </tr>
                    
                </table>           
            </td>
        </tr>
        <?php }?>
        <tr>
            <td align="right" colspan="2" style="padding: 10px; border-bottom: 1px solid #ccc;border-right: 1px solid #ccc;">
                <button type="submit" style="background: #44a1ef; color: #fff; border:none; padding: 10px 20px; border-radius: 4px; cursor: pointer;">
                                        {{getPhrase('print')}}
                                    </button>
            </td>
        </tr>
        
    </table>
                  

    {!!Form::close()!!}
</body>


</html>