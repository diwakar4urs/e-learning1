 

      /**
      * Intilize select by default
      */
    $('.select2').select2({
       placeholder: "Select",
    });

        $('#select_academic_year').select2({
       placeholder: "Select Academic Year",
    });

	/**
	 * By default apply plugin for selectbox along with events
	 */
  	$('#course_parent_id').select2()

  	.on('select2:select', function(evt){
	  	fillCourses($(this).val());
	});
 
  	 /**
  	  * Intilize select course ddl
  	  */
  //   $('#select_course').select2({
  //      placeholder: "First select branch",
  //   })
  //   .on('select2:select', function(evt){
  //     getFeeScheduledCourses($(this).val());
  // });

    $('#course_parent_id').select2({
  		   placeholder: "Select a branch",
         allowClear: true
  	});

  	/**
  	 * Get the list of courses associated with academic ID
  	 * @param  {Integer} selected_id [selected academic ID]
  	 * @return {[type]}             [description]
  	 */
  	function fillCourses(selected_id)
  	{
  		
  		$('#select_course').select2().empty().trigger('change');
       academic_id = $('#select_academic_year').val();
       fee_scheduled_id = $('#fee_scheduled_id').val();

  		  token = $('[name="_token"]').val();
		  	route = '/fee/schedules/getScheduledCourses';  
		    $.ajax({
		        url:route,
		        type: 'post',
		         dataType: 'json',
		        data: {_method: 'post', '_token':token, 
                  'academic_id': academic_id, 
                  'course_parent_id': selected_id, 
                  'fee_scheduled_id': fee_scheduled_id},
		        success:function(list){
              console.log(list);
              console.log(list.course_list);
              // dta = $.parse_JSON(list);
              // console.log(dta['course_list']);
		        	$('#select_course').select2({
		        		data: list.course_list
		        	}).trigger('change');
              $('#select_course').val(list.selected_list);
            $('#select_course').select2().trigger('change');
         
		        }
		    });
  	}

    // function getFeeScheduledCourses(course_id)
    // {

    //   academic_id = $('#select_academic_year').val();
    //   token = $('[name="_token"]').val();
      
    //   route = '/fee/categories/get_alloted-categories';  
    //     $.ajax({
    //         url:route,
    //         type: 'post',
    //          dataType: 'json',
    //         data: {_method: 'post', '_token':token, 'academic_id': academic_id, 'course_id': course_id},
    //         success:function(list){
            
    //          $('#fee_categories').val(list);
    //         $('#fee_categories').select2().trigger('change');
    //         }
    //     });

      
    // }
 