<script src="{{JS}}angular.js"></script>
 <script src="{{JS}}ngStorage.js"></script>
<script src="{{JS}}angular-messages.js"></script>
<script src="{{JS}}plugins/dragdrop/ngDraggable.js"></script>

<script>
var app = angular.module('academia', ['ngMessages','ngDraggable']);
app.controller('MapTimingsetController', function( $scope, $http, $timeout) {
   
    $scope.academic_years =[];
    $scope.parent_courses =[];
     $scope.courses = [];
     $scope.parent_selected = false;
     $scope.years = [];
      $scope.source_items = [];
      $scope.target_items = [];
      $scope.academic_id = '';
      $scope.course_parent_id = '';
      $scope.course_id = '';
     
    $scope.initAngData = function(data) {
        
          angular.forEach(data.academic_years, function(value, key) {
             $scope.academic_years.push(value);
          });
        angular.forEach(data.available_items, function(value, key) {
             
           record = {  
                    'id': value.academic_id+'_'+value.course_parent_id+'_'+value.course_id+'_'+value.year,
                    'year': value.year,
                    'academic_id': value.academic_id,
                    'academic_title': value.academic_year_title,
                    'course_parent_id': value.course_parent_id,
                    'course_id': value.course_id,
                    'course_title': value.course_title,
                 };
                 $scope.target_items.push(record);

          });
        
        angular.forEach(data.source_items,function(value,key){
            $scope.source_items.push(value);
         });
         angular.forEach(data.target_items,function(value,key){
            $scope.target_items.push(value);
         });
    }
    
    $scope.getParentCourses = function(academic_id){
     
    if(academic_id=='')
      return;
  
      route = '{{URL_ACADEMICS_COURSES_GET_PARENT_COURSES}}';  
    data= {_method: 'post', '_token':$scope.getToken(), 'academic_id': academic_id};
     $http.post(route, data).success(function(result, status) {
      $scope.parent_courses = result;
        });
     }

    $scope.getChildCourses = function(academic_id, parent_course_id){
         
        if(academic_id=='')
          return;
        
        if(parent_course_id=='')
          return ;
      $scope.academic_id = academic_id;
       $scope.course_parent_id = parent_course_id;
        route = '{{URL_ACADEMICS_COURSES_GET_CHILD_COURSES}}';  
        data= {   _method: 'post', 
                  '_token':$scope.getToken(), 
                  'academic_id': academic_id, 
                  'parent_course_id': parent_course_id
              };
        $http.post(route, data).success(function(result, status) {
        $scope.courses = [];
        angular.forEach(result, function(obj, index){
          $scope.courses.push(obj.course);
        });
        $scope.parent_selected = true;

        });
    }

    $scope.prepareYears = function(course){
        $scope.course_id = course;
        console.log(course);
        years = [];
        index = $scope.findIndexInData($scope.courses, 'id', course);
         
        total_years            = $scope.courses[index].course_dueration;
        course_record          = $scope.courses[index];
        course_id              = course_record.id;
        course_parent_id       = course_record.course_parent_id;
        academic_id            = course_record.academic_id;
        $scope.years= [];
        for(i=1; i<=total_years; i++)
        {
          id = academic_id+'_'+course_parent_id+'_'+course_id+'_'+i;
          index = $scope.findIndexInData($scope.target_items, 'id', id);
          
          if(index==-1){
            record = {id: id, year: i};
            years.push(record);
          }
        }
        
         $scope.source_items = years;
           
      }

       /**
         * This event is triggered when an item is dropped on droppable div
         * @param  {[type]} data [description]
         * @param  {[type]} evt  [description]
         * @return {[type]}      [description]
         */
       $scope.onDropComplete=function(data,evt, item_id ){
       

        academic_record       = $scope.getFullRecord($scope.academic_years, 'id', $scope.academic_id);
        course_parent_record  = $scope.getFullRecord($scope.parent_courses, 'id', $scope.course_parent_id);
        course_record         = $scope.getFullRecord($scope.courses, 'id', $scope.course_id);
        
        id = academic_record.id+'_'+course_parent_record.id+'_'+course_record.id+'_'+data.year;
       
        record = {  
                    'id': id,
                    'year': data.year,
                    'academic_id': academic_record.id,
                    'academic_title': academic_record.academic_year_title,
                    'course_parent_id': course_parent_record.id,
                   // 'course_parent_title': course_parent_record.course_title,
                    'course_id': course_record.id,
                    'course_title': course_record.course_title,
                 };
           
          index = $scope.findIndexInData($scope.target_items, 'id', record.id);
          if(index==-1){
            $scope.target_items.unshift(record);
              $timeout( function(){ 

                $scope.removeItem(data, $scope.source_items,'source_items');
            }, 100);
              //The below method removes item from source list and resets count
          }
          else
            alertify.error('{{getPhrase('already_item_available')}}');
    }

    $scope.getFullRecord = function (source, key, value) {
         index = $scope.findIndexInData(source, key, value);
        return source[index];
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
      $scope.removeItem = function(item, source, id) { 
          $('#'+id+'-'+item.id).addClass('animated {{ANIMATION_REMOVE}}');
        $timeout( function(){ 
       
           index = $scope.findIndexInData(source, 'id', item.id);
        
           source.splice(index, 1);   
           if(id=='target_items')  
             alertify.success('{{getPhrase('item_removed_successfully')}}');
         }, 500);
        
        //Push the removed items to source list     
        if(id=='target_items') {
          
           res = $scope.findIndexInData($scope.source_items, 'id', item.id);
           if(res == -1){
              $scope.source_items.unshift(item);
              // console.log($scope.source_items);
           }
        }

          //$scope.resetCount();
        }

         

     /**
     * Returns the token by fetching if from from form
     * 
     */
    $scope.getToken = function(){
      return  $('[name="_token"]').val();
    }

}  );

app.filter('cut', function () {
        return function (value, wordwise, max, tail) {
            if (!value) return '';

            max = parseInt(max, 10);
            if (!max) return value;
            if (value.length <= max) return value;

            value = value.substr(0, max);
            if (wordwise) {
                var lastspace = value.lastIndexOf(' ');
                if (lastspace != -1) {
                  //Also remove . and , so its gives a cleaner result.
                  if (value.charAt(lastspace-1) == '.' || value.charAt(lastspace-1) == ',') {
                    lastspace = lastspace - 1;
                  }
                  value = value.substr(0, lastspace);
                }
            }

            return value + (tail || ' …');
        };
    });

app.filter('searchTopic',function(){
    return function(items,topic){
        var result=[];
        if(topic && items.length>0){
            angular.forEach(items,function(value,key){
            if(topic.id==value.topic_id){
                result.push(value);
            }   
        });
        }
        return result;
    }

});

app.filter('searchQuestion',function(){
    
    return function(item){
    questions =  JSON.parse(localStorage.getItem('saved_questions'));;
    
        var result=[];
        if(questions == 'undefined' || questions == null)
            return item;

            angular.forEach(questions, function(value,key){
            if(item.id != value.question_id){
                result.push(item);
            }   
        });
        
        return result;
    }

 });

 
</script>