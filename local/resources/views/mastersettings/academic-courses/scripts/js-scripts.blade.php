<script src="{{JS}}angular.js"></script>
<script src="{{JS}}plugins/dragdrop/ngDraggable.js"></script>

<script >
  var app = angular.module('academia', ['ngDraggable']);
</script>

@include('common.angular-factory',array('load_module'=> FALSE))
<script>

     app.controller('academicCourses', function ($scope, $timeout, httpPreConfig) {
      
     $scope.courses = [];
      $scope.allocated_courses = [];
      
      search='';
      /**
       * This method intilize the default data to allocated courses and available courses
       * @param  {[type]} data [description]
       * @return {[type]}      [description]
       */
     	$scope.ingAngData = function(data) {
         angular.forEach(data.courses,function(value,key){
            $scope.courses.push(value);
         });
         angular.forEach(data.allocated_courses,function(value,key){
            $scope.allocated_courses.push(value);
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
       $scope.onDropComplete=function(data,evt){
        
        res = httpPreConfig.findIndexInData($scope.allocated_courses, 'id', data.id);
          if(res==-1){
            $scope.allocated_courses.push(data);
            $('#allocated_courses-'+data.id).addClass('animated {{ANIMATION_ADD}}');
          }
          else
            alertify.error('{{getPhrase('already_item_available')}}');
    }

     

      /**
       * This method removes specific item passed by it
       * @param  {[type]} item [description]
       * @return {[type]}      [description]
       */
      $scope.removeItem = function(item, academic_id) { 

        
      httpPreConfig.showConfirmation().then(function(result){
                 
        if(result==1){

          route = '{{URL_MASTERSETTINGS_ACADEMICS_COURSES_STATUS}}';  
          data= {   _method: 'post', 
                    '_token':httpPreConfig.getToken(), 
                    'academic_id': academic_id, 
                    'course_id': item.id,
                };
         
      httpPreConfig.webServiceCallPost(route, data).then(function(result){
         result = result.data;
          if(result==0) {
          $('#allocated_courses-'+item.id).addClass('animated {{ANIMATION_REMOVE}}');

        $timeout( function(){ 
          var index = $scope.allocated_courses.indexOf(item);
           index = httpPreConfig.findIndexInData($scope.allocated_courses, 'id', item.id);
           $scope.allocated_courses.splice(index, 1);     
             alertify.success('{{getPhrase('item_removed_successfully')}}');
         }, 500);
      }
      else{
             alertify.error('{{getPhrase('cannot_remove_this_item_as_it_is_in_use')}}');
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

  })
</script>
