
 	   $scope.year_selected             = false;
     
     $scope.selected_academic_id      = '';
     $scope.selected_course_parent_id = '';
     $scope.selected_course_id        = '';
     $scope.selected_year             = '';
     $scope.selected_semister         = 0;  
     $scope.courses_object            = [];
     $scope.total_semisters           = 0;
     $scope.semisters                 = [];
     $scope.have_semisters            = false;
     $scope.parent_courses            = [];
     $scope.courses                   = [];
     $scope.parent_selected           = false;
     $scope.years                     = [];
     $scope.result_data               = [];
    
    @if(isset($user_slug))
     $scope.pre_selected_academic_id = '';
     $scope.pre_selected_course_parent_id = '';
     $scope.pre_selected_course_id = '';
     $scope.pre_selected_year = 1;
     $scope.pre_selected_semister = 0;
    @endif

     $scope.resetYears = function(){

         $scope.years           = [];
         $scope.selected_year   = null;
         $scope.current_year    = null;
         
         $scope.result_data = [];
         $scope.resetSemisters();
      }

      $scope.resetSemisters = function(){
      
        $scope.total_semisters = 0;
        $scope.semisters = [];
        $scope.have_semisters = false;
        $scope.current_semister = '';
        $scope.result_data=[];
      }

      $scope.resetCourses = function(){

         $scope.selected_course_id = '';
         $scope.courses         = [];
         $scope.resetYears();
      }

      $scope.resetParentCourses = function(){

        $scope.parent_courses  = [];
        $scope.selected_course_parent_id = '';
        $scope.course_parent_id = '';
        $scope.resetCourses();
      }


        $scope.resetFields = function(){

        $scope.selected_academic_id = '';
        $scope.resetParentCourses();
        
      }


      $scope.getParentCourses = function(academic_id)
      {
       
        if(academic_id=='')
          return;
         $scope.resetFields();

        $scope.selected_academic_id = academic_id;
          route = '{{URL_ACADEMICS_COURSES_GET_PARENT_COURSES}}';  
        data= {  _method: 'post', 
                '_token':httpPreConfig.getToken(),
                'academic_id': academic_id
              };
             
         httpPreConfig.webServiceCallPost(route, data).then(function(result){
          $scope.parent_courses = result.data;
          
          if($scope.pre_selected_course_parent_id)
          {
              index = httpPreConfig.findIndexInData(
                                    $scope.parent_courses,'id',
                                    $scope.pre_selected_course_parent_id
                                    );
              $scope.course_parent_id = $scope.parent_courses[index];              
              $scope.getChildCourses($scope.selected_academic_id, $scope.pre_selected_course_parent_id);
          }
           
        });
      }

      $scope.getChildCourses = function(academic_id, parent_course_id){
         
        if(academic_id=='')
          return;
        
        if(parent_course_id=='')
          return ;
       
        $scope.resetCourses();

       $scope.selected_course_parent_id = parent_course_id;
        route = '{{URL_ACADEMICS_COURSES_GET_CHILD_COURSES}}';  
        
        data= {   _method: 'post', 
                  '_token':httpPreConfig.getToken(), 
                  'academic_id': academic_id, 
                  'parent_course_id': parent_course_id
              };
        httpPreConfig.webServiceCallPost(route, data).then(function(result){
        angular.forEach(result.data, function(value, key){
          $scope.courses.push(value.course);
          $scope.courses_object.push(value);
          
        });
        
        $scope.parent_selected = true;

         if($scope.pre_selected_course_id)
          {
              index = httpPreConfig.findIndexInData(
                                     $scope.courses,'id',
                                    $scope.pre_selected_course_id
                                    );
              $scope.course_id = $scope.courses[index];              
              $scope.prepareYears($scope.pre_selected_course_id)
          }


        });
      }

      $scope.prepareYears = function(course){
        $scope.resetYears();
       if(course==null)
        {
          return;
        }

        index = httpPreConfig.findIndexInData($scope.courses, 'id', course);
        total_years               = $scope.courses[index].course_dueration;
        $scope.selected_course_id = $scope.courses[index].id;
        

      
      if(total_years==1) {
        $scope.selected_semister = 0;
        $scope.selected_year = 1;
         @if(!isset($doCall)) 
        $scope.doCall();
        @endif
        return;
      }
      


        $scope.years = { "current_year": "Select","values": ['Select'] };
        for(i=1; i<=total_years; i++)
        {
          $scope.years.values.push(i);
        }
       
        $scope.current_year = 'select';
        if($scope.pre_selected_year)
          {
              $scope.years.current_year = $scope.pre_selected_year;              
              $scope.current_year = $scope.years.current_year;
              $scope.yearChanged($scope.years.current_year)
          }
        
      }

        $scope.yearChanged     = function (year_number) {
        $scope.resetSemisters();

      $scope.year_selected   = true;
      
      academic_id          = $scope.selected_academic_id;
      parent_course_id     = $scope.selected_course_parent_id;
      course_id            = $scope.selected_course_id;
      $scope.selected_year = year_number;
      year                 = year_number;

      
        angular.forEach($scope.courses_object, function(course, key){
         if(course.course.id == course_id){
          angular.forEach(course.semister, function(semister, no){
            if(semister.year== year){
              if(semister.total_semisters>0)
              {
                semisters =[];

                $scope.semisters = { "current_semister": "Select","values": ['Select'] };
                for(i=1; i<=semister.total_semisters; i++)
                {
                  $scope.semisters.values.push(i);
                }
               
                $scope.current_semister = 'select';
                $scope.total_semisters = semister.total_semisters;
                $scope.have_semisters = true;
              }
              else
              {
                $scope.total_semisters = 0;
                $scope.semisters = [];
                $scope.have_semisters = false;
              }
              
            }
          });
        }
        });
       @if(!isset($doCall))  
       if(!$scope.have_semisters)
        $scope.doCall();
       @endif
    }

    $scope.semisterChanged = function(current_semister){
      $scope.selected_semister = current_semister;
      @if(!isset($doCall))  
      $scope.doCall();
      @endif
    }

    $scope.setPreSelectedData = function(
                                          academic_id, 
                                          parent_course_id, 
                                          course_id, 
                                          year, 
                                          semister) {
       $scope.pre_selected_academic_id = academic_id;
       $scope.pre_selected_course_parent_id = parent_course_id;
       $scope.pre_selected_course_id = course_id;
       $scope.pre_year = year;
       $scope.pre_semister = semister;
       $scope.academic_year = $scope.pre_selected_academic_id;
       $scope.selected_academic_id = $scope.academic_year;
      
      $scope.getParentCourses($scope.academic_year);
    }
    
 
    