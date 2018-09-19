var app = angular.module('academia', []);
app.controller('courseSubjectsController', function($scope, $http) {

    /**
     * Gets the no. of years based on the dueration for that course
     * @return {[type]} [description]
     */
    $scope.getYears = function()
    {
      $scope.haveSems = 0;
      $scope.selectedYear = 1;
      $scope.selectedSemister = 0;
      route = '/mastersettings/course-subjects/getCourseYears';  
      data= {_method: 'post', '_token':$scope.getToken(), 'course_id': $scope.selectedCourse};
    
      $http.post(route, data).success(function(result, status) {
            /*
            | Pouplate the years based on selected course dueration
             */
             $('#select_year').populate(result.course_dueration, '#select_year');
             $scope.haveSems = result.is_having_semister;

            
            /*
            | Populate the semisters information based on course and year 
            | with common method fillSemisters()
             */
             if($scope.haveSems)
              $scope.fillSemisters();

            $scope.getSavedSubjects();

        });
    }

    /**
     * Fills the semisters based on selected course and year
     * @return {[type]} [description]
     */
    $scope.fillSemisters = function(){
       $scope.getSavedSubjects();
        if(!$scope.haveSems)
            return;
      route = '/mastersettings/course-subjects/getSemisters';  
      data= { 
              _method     : 'post', 
              '_token'    : $scope.getToken(), 
              'course_id' : $scope.selectedCourse,
              'year'      : $scope.selectedYear
            };
    
      $http.post(route, data).success(function(result, status) {
        
        if(!result.total_semisters) {
          /*
           | If any specific course year have no semistes then
           | It will be executing this condition code or 
           | this is the default option for the courses which have no sems 
           | for specific year 
           */
           $('#semister').empty();
          $('#semister').append('<option value="0">No Semisters</option>');
          
          return;
        }

        $('#semister')
         .populate(result.total_semisters, '#semister');
          
        });
    
    }

    /*
    | Get the selected combination of data as below
    | AcademicID, CourseParentID, CourseID, Year, [Semister]
    | Make a call to server and fetch if any information is available 
    | If available display the selected list of subjects
    | If not available leave as it is
     */
    $scope.getSavedSubjects = function() {
       
       if(  !$scope.selectedYear 
            ||  !$scope.selectedParentCourse 
            ||  !$scope.selectedCourse
            ||  !$scope.academicYear
            ) {
        //As insufficient data selected, could not make a call
        return; 
       }

      route = '/mastersettings/course-subjects/getSavedSubjects'; 
      data= { 
              _method     : 'post', 
              '_token'    : $scope.getToken(), 
              'course_id' : $scope.selectedCourse,
              'year'      : $scope.selectedYear,
              'academicId': $scope.academicYear,
              'courseParentId': $scope.selectedParentCourse,
              'semister'  : $scope.selectedSemister,
            };

  
      $http.post(route, data).success(function(result, status) {
           $('#subjects').val(result);

      });
    }

    /**
     * Returns the token by fetching if from from form
     * 
     */
    $scope.getToken = function(){
      return  $('[name="_token"]').val();
    }

});

 
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

    $.fn.populate = function(dueration, id) {
      $this =  $(id);
      $this.empty();
      for(year = 1; year<= dueration; year++)
        $(this).append('<option value="'+year+'">'+year+'</option>')

    }
 
 function deleteRecordCustom(academic_id, course_id) {
  swal({
      title: "Are you sure?",
      text: "You will not be able to recover this record! "+academic_id+'--'+course_id,
      type: "warning",
      showCancelButton: true,
      confirmButtonClass: "btn-danger",
      confirmButtonText: "Yes, delete it!",
      cancelButtonText: "No, cancel pls!",
      closeOnConfirm: false,
      closeOnCancel: false
    },
    function(isConfirm) {
      if (isConfirm) {
       var token = $('[name="_token"]').val();
       route = '/mastersettings/course-subjects/delete/';  
       data= { 
          _method     : 'delete', 
          '_token'    : token, 
          'course_id' : course_id,
          'academic_id': academic_id,
        };



        $.ajax({
            url:route,
            type: 'post',
            data: data,
            success:function(msg){
              tableObj.ajax.reload();
              swal("Deleted!", "Your record has been deleted. ", "success");
            }
        });

      } else {
        swal("Cancelled", "Your record is safe :)", "error");
      }
  });
  }