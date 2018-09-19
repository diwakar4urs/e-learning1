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
      fillCourses($(this).val(), 0);
  });  

  $('#select_course').select2({
  		 
  	})

  	.on('select2:select', function(evt){
	  	  fillCourses($('#select_course').val(), 1);
    
      
	});
 

  	 /**
  	  * Intilize select course ddl
  	  */
    $('#select_course').select2({
       placeholder: "First select branch",
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
  	function fillCourses(selected_id, whole_record)
  	{
  		if(!whole_record)
  		$('#select_course').select2().empty().trigger('change');
  		
		  	route = '/student/courses/'+selected_id+'/'+whole_record;  
		    $.ajax({
		        url:route,
		        type: 'post',
		         dataType: 'json',
		        data: {_method: 'get'},
		        success:function(list){
              if(!whole_record) {
		        	$('#select_course').select2({
		        		data: list
		        	}).trigger('change');
              return;
            }
           
             if(list.is_having_semister ==1) {
              $('#semister-div').fadeIn();
              }
              else {
                $('#semister-div').fadeOut();
              }
             showDuration('#year',list.course_dueration, 'Year');

		        }
		    });
  	}
 
  function showDuration(element, duration, type) {
   options = '<option value="">Select '+type+'</option>';
   for(i=1; i<=duration; i++)
    options += '<option value="'+i+'">'+i+'</option>';
   
  $(element).empty().append(options);
 }


 $('#year').change(function(){
  yearHasSemister($('#select_course').val(), $(this).val());


 })

 function yearHasSemister(courseId, year) {
   route = '/student/course-semister/'+courseId+'/'+year;
   $.ajax({
            url:route,
            type: 'post',
             dataType: 'json',
            data: {_method: 'get'},
            success:function(list){
              if(list.total_semisters >0 ) {
                showDuration('#semister',list.total_semisters, 'Sem');
                $('#semister-div').fadeIn();
              }
              else
                $('#semister-div').fadeOut();
            }
        });
 }

 
  function getSubjects(courseId, year) {
   route = '/student/course-semister/'+courseId+'/'+year;
   $.ajax({
            url:route,
            type: 'post',
             dataType: 'json',
            data: {_method: 'get'},
            success:function(list){
              if(list.total_semisters >0 ){
                showDuration('#semister',list.total_semisters, 'Sem');
                $('#semister-div').fadeIn();
              }
              else
                $('#semister-div').fadeOut();
            }
        });
 }

 
 