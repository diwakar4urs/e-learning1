<script src="{{JS}}angular.js"></script>
<script src="{{JS}}plugins/dragdrop/ngDraggable.js"></script>
<script >
  var app = angular.module('academia', ['ngDraggable']);
</script>

@include('common.angular-factory',array('load_module'=> FALSE))
<script>
 
app.controller('courseSubjectsController', function($scope, $http, $timeout, httpPreConfig, $q) {

     $scope.parent_courses =[];
     $scope.courses = [];
     $scope.parent_selected = false;
     $scope.years = [];
     $scope.course_selected = 0;
     $scope.source_items = [];
     userData = null;
     $scope.default_classes_needed = '{{DEFAULT_CLASSES_NEEDED}}';
     
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
      
         angular.forEach(data.source_items,function(value,key){
          source_item = value;
          source_item['preference'] = data.preferred_subjects[value.id];
            $scope.source_items.push(source_item);
         });
           $scope.course_selected = 0;

            if(data.target_items!=null){

         angular.forEach(data.target_items,function(value,key){
          userData = null;
          if(value.staff_id!=0)
          {
            index = $scope.findIndexInData($scope.source_items, 'id', value.staff_id);
            userData = $scope.source_items[index];
          }
            var extraData = {
              index:value.year+'_'+value.semister+'_'+value.id,
              user: userData 
            };

            angular.extend(value,extraData);

            $scope.target_items.push(value);
         });
        }

         
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
       $scope.onDropComplete=function(data,evt, id, academic_id, course_id,year,semister, user_id,subject){
       
        res = httpPreConfig.findIndexInData($scope.target_items, 'index', id);
          
          if(res!=-1){

            if(!$scope.target_items[res].user)
            {
              $scope.target_items[res].user = data;
            }

             object_data= {   _method: 'post', 
                  '_token':httpPreConfig.getToken(), 
                  'academic_id': academic_id, 
                  'course_id': course_id,
                  'subject_id': subject.id,
                  'year': year,
                  'semister': semister,
                  'user_id': $scope.target_items[res].user.id,
              };
              


              $scope.checkStatus(object_data).then(function(result){
               
                if(result==0){
                    $scope.target_items[res].user = data;
              $timeout( function(){ 
              $('#target_items-'+data.id).addClass('animated {{ANIMATION_ADD}}');
            }, 0);
                }
                else{
                  alertify.error('{{getPhrase('cannot_remove_as_staff_is_assigned_to_classes')}}');      
                }
              });
              
          
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

        $scope.checkStatus = function(data){
          var deferred = $q.defer();
          result_data = 0;
           route = '{{URL_IS_STAFF_ALLOCATED_TO_TIMETABLE}}';  
            httpPreConfig.webServiceCallPost(route, data).then(function(result){
              result_data = result.data;
              deferred.resolve(result_data);
            });
            
            return deferred.promise;

        }

      /**
       * This method removes specific item passed by it
       * @param  {[type]} item [subject record]
       * @param  {[type]} item [subject record]
       * @return {[type]}      [description]
       */
      $scope.removeItem = function(item, source, id,academic_id, course_id, year, semister,user_id) { 
 
        // return;
        httpPreConfig.showConfirmation().then(function(result){
                 
        if(result==1){

          
        data= {   _method: 'post', 
                  '_token':httpPreConfig.getToken(), 
                  'academic_id': academic_id, 
                  'course_id': course_id,
                  'subject_id': item.id,
                  'year': year,
                  'semister': semister,
                  'user_id': user_id,
              };
         
         $scope.checkStatus(data).then(function(result){
              if(result==0){

           $('#'+id+'-'+item.id).addClass('animated {{ANIMATION_REMOVE}}');
        $timeout( function(){ 
         
           index = httpPreConfig.findIndexInData(source, 'index', item.index);
         
           source[index].user = null;
             
           if(id=='target_items')  
             alertify.success('{{getPhrase('staff_removed_successfully')}}');
         }, 500);
          }
          else {
             alertify.error('{{getPhrase('cannot_remove_as_staff_is_assigned_to_classes')}}');
          }
          });
        
       

            }


        });
      

          // $scope.resetCount();
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