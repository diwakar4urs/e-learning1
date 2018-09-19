<script src="{{JS}}angular.js"></script>
<script src="{{JS}}plugins/dragdrop/ngDraggable.js"></script>


<script >
  var app = angular.module('academia', ['ngDraggable']);
</script>

@include('common.angular-factory',array('load_module'=> FALSE))

<script>

app.controller('courseSubjectsController', function($scope, $http, $timeout, httpPreConfig) {

     $scope.parent_courses =[];
     $scope.courses = [];
     $scope.parent_selected = false;
     $scope.years = [];
     $scope.course_selected = 0;
     $scope.source_items = [];

     $scope.default_classes_needed = '{{getSetting('default_sessions_needed','time_table')}}';
     
     $scope.target_items = [];
     @foreach($keys as $key)
     $scope.target_items['{{$key}}'] = [];
     @endforeach

      search='';

      /**
       * This method intilize the default data to allocated courses and available courses
       * @param  {[type]} data [description]
       * @return {[type]}      [description]
       */
      $scope.ingAngData = function(data) {
         
         if(data.target_items!=null){
         angular.forEach(data.target_items,function(value,key){

            $scope.target_items[value.year+'_'+value.semister].push(value);
         });
        }
         angular.forEach(data.source_items,function(value,key){
 
            $scope.source_items.push(value);
         });
           $scope.course_selected = 0;

      }

       $scope.getParentCourses = function(academic_id){
         
        if(academic_id=='')
          return;

          route = '{{URL_ACADEMICS_COURSES_GET_PARENT_COURSES}}';  
        data= {_method: 'post', '_token':httpPreConfig.getToken(), 'academic_id': academic_id};
         httpPreConfig.webServiceCallPost(route, data).then(function(result){
          result = result.data;
          $scope.parent_courses = result;
        });
      }

      $scope.getChildCourses = function(academic_id, parent_course_id){
         
        if(academic_id=='')
          return;
        
        if(parent_course_id=='')
          return ;
       
        route = '{{URL_ACADEMICS_COURSES_GET_CHILD_COURSES}}';  
        data= {   _method: 'post', 
                  '_token':httpPreConfig.getToken(), 
                  'academic_id': academic_id, 
                  'parent_course_id': parent_course_id
              };
         httpPreConfig.webServiceCallPost(route, data).then(function(result){
          result = result.data;
        $scope.courses = [];
         angular.forEach(result, function(obj, index){
          $scope.courses.push(obj.course);
        });
        
        $scope.parent_selected = true;

        });
      }

      $scope.course_selected = function (course_id) {

        if(course_id)
          $scope.course_selected = 1;
        else
          $scope.course_selected = 0;
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

      route = '{{URL_MASTERSETTINGS_COURSE_SUBJECTS_GET_COURSE_SAVED_SUBJECTS}}'; 
      data= { 
              _method     : 'post', 
              '_token'    : httpPreConfig.getToken(), 
              'course_id' : $scope.selectedCourse,
              'year'      : $scope.selectedYear,
              'academicId': $scope.academicYear,
              'courseParentId': $scope.selectedParentCourse,
              'semister'  : $scope.selectedSemister,
            };

  
       httpPreConfig.webServiceCallPost(route, data).then(function(result){
        result = result.data;
           $('#subjects').val(result);

      });
    }

    

     /**
         * This event will be generated when the drag has stopped.
         * Current we are not using this event, if required we can use it
         * @param  {[type]} data [description]
         * @param  {[type]} evt  [description]
         * @return {[type]}      [description]
         */
        $scope.onDragComplete=function(data,evt){
        /**
         * Write the necessory code for it
         */
        }

        /**
         * This event is triggered when an item is dropped on droppable div
         * @param  {[type]} data [description]
         * @param  {[type]} evt  [description]
         * @return {[type]}      [description]
         */
       $scope.onDropComplete=function(data,evt, id){
         
        res = $scope.findIndexInData($scope.target_items[id], 'id', data.id);
          if(res==-1){

            $scope.target_items[id].unshift(data);
              $timeout( function(){ 
              $('#target_items-'+data.id).addClass('animated {{ANIMATION_ADD}}');
            }, 0);
              //The below method removes item from source list and resets count
          }
          else
            alertify.error('{{getPhrase('already_item_available')}}');
    }

     /**
     * This method is used to find an element on specific condition in an array of objects
     * @param  {[type]} Array    [the sourse of an array]
     * @param  {[type]} property [the property of the object]
     * @param  {[type]} action   [the value need to be searched]
     * @return {[type]}          [returns an index of the element from source]
     */
     $scope.findIndexInData =function (Array, property, action) {
          var result = -1;
          angular.forEach(Array, function(value, index) {
             if(value[property]==action){
                result=index;
             }
          });
          return result;
        }

      /**
       * This method removes specific item passed by it
       * @param  {[type]} item [description]
       * @return {[type]}      [description]
       */
      $scope.removeItem = function(item, source, id, academic_id, course_id, year, semister) { 
 
        httpPreConfig.showConfirmation().then(function(result){
        
        if(result==1){

            route = '{{URL_ACADEMICS_REMOVE_SUBJECT}}';  
        data= {   _method: 'post', 
                  '_token':httpPreConfig.getToken(), 
                  'academic_id': academic_id, 
                  'course_id': course_id,
                  'subject_id': item.id,
                  'year': year,
                  'semister': semister,
              };
         httpPreConfig.webServiceCallPost(route, data).then(function(result){
          result = result.data;
          if(result==0)
          {
            //This subject is not allocated to any course
              $('#'+id+'-'+item.id).addClass('animated {{ANIMATION_REMOVE}}');
        $timeout( function(){ 
          var index = source.indexOf(item);
           index = httpPreConfig.findIndexInData(source, 'id', item.id);
           source.splice(index, 1);   
           if(id=='target_items')  
             alertify.success('{{getPhrase('item_removed_successfully')}}');
         }, 500);
          }
          else{
            alertify.error('{{getPhrase('cannot_remove_this_subject_as_allocated_to_staff')}}');
          }
         });
          
        
        
      }


        });

        }

        /**
         * This method is used to filter the items on specific condition
         * @param  {[type]} item   [description]
         * @param  {[type]} source [description]
         * @return {[type]}        [description]
         */
        $scope.filterItems = function(item, source){
          newList = [];
          source.forEach(function(value,key){
            if(value.id != item.id)
              newList.push(value);
          });
          return newList;
        }

});

  
 
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
       route = '{{URL_MASTERSETTINGS_COURSE_SUBJECTS_DELETE}}';  
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
  </script>