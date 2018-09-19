 

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
  	$('#course_parent_id').select2({
  		 placeholder: "Select Branch",
  	})

  	.on('select2:select', function(evt){
	  	fillCourses($(this).val());
	});
 
  	 /**
  	  * Intilize select course ddl
  	  */
    $('#select_course').select2({
       placeholder: "First select branch",
    })
    .on('select2:select', function(evt){
      getFeeCategories($(this).val());
  });

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
  		
		  	route = '/student/courses/'+selected_id;  
		    $.ajax({
		        url:route,
		        type: 'post',
		         dataType: 'json',
		        data: {_method: 'get'},
		        success:function(list){
		        	$('#select_course').select2({
		        		data: list
		        	}).trigger('change');
		        }
		    });
  	}

    function getFeeCategories(course_id)
    {

      academic_id = $('#select_academic_year').val();
      token = $('[name="_token"]').val();
      
      route = '/fee/categories/get_alloted-categories';  
        $.ajax({
            url:route,
            type: 'post',
             dataType: 'json',
            data: {_method: 'post', '_token':token, 'academic_id': academic_id, 'course_id': course_id},
            success:function(list){
            
             $('#fee_categories').val(list);
            $('#fee_categories').select2().trigger('change');
            }
        });

      
    }
 