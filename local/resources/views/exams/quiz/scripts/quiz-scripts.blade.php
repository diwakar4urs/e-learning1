<script src="{{JS}}angular.js"></script>
 <script src="{{JS}}ngStorage.js"></script>
<script src="{{JS}}angular-messages.js"></script>
<script src="{{JS}}plugins/dragdrop/ngDraggable.js"></script>

<script >
var app = angular.module('academia', ['ngMessages','ngDraggable']);
</script>

@include('common.angular-factory',array('load_module'=> FALSE))

<script>

app.controller('QuizController', function( $scope, $http, $timeout, httpPreConfig) {
   
    $scope.academic_years =[];
    $scope.parent_courses =[];
    $scope.courses = [];
    $scope.courses_data = [];
    $scope.parent_selected = false;
    $scope.years = [];
    $scope.source_items = [];
    $scope.target_items = [];
    $scope.academic_id = '';
    $scope.course_parent_id = '';
    $scope.course_id = '';
    $scope.showCourses=false; 
     
    $scope.initAngData = function(data) {
     

        angular.forEach(data.academic_years, function(value, key) {
             $scope.academic_years.push(value);
          });

        angular.forEach(data.available_items, function(value, key) {
             
           record = {  
                    'id': value.academic_id+'_'+value.course_parent_id+'_'+value.course_id+'_'+value.year+'_'+value.semister,
                    'year': value.year,
                    'semister': value.semister,
                    'academic_id': value.academic_id,
                    'academic_title': value.academic_year_title,
                    'course_parent_id': value.course_parent_id,
                    'course_id': value.course_id,
                    'course_title': value.course_title,
                    'course_dueration': value.course_dueration,
                 };
                 $scope.target_items.push(record);

          });
        
    }
    

    $scope.resetYears = function(){

         $scope.years           = [];
         $scope.selected_year   = null;
         $scope.current_year    = null;
         
         $scope.result_data = [];
         $scope.source_items         = [];
         
      }

   
      $scope.resetCourses = function(){

         $scope.selected_course_id = '';
         $scope.courses         = [];
         $scope.source_items         = [];
         $scope.resetYears();
      }

      $scope.resetParentCourses = function(){

        $scope.parent_courses  = [];
        $scope.selected_course_parent_id = '';
        $scope.course_parent_id = '';
        
        $scope.resetCourses();
      }


    $scope.getParentCourses = function(academic_id){
     
    if(academic_id=='')
      return;
  $scope.resetParentCourses();
  // $scope.resetCourses();
      route = '{{URL_ACADEMICS_COURSES_GET_PARENT_COURSES}}';  
    data= {_method: 'post', '_token':$scope.getToken(), 'academic_id': academic_id};
      httpPreConfig.webServiceCallPost(route, data).then(function(result){
        result = result.data;
      $scope.parent_courses = [];
      obj = {id:'',course_title:'Select'};
      $scope.parent_courses.push(obj);

      angular.forEach(result, function(value, key){
        obj = {id:value.id,course_title:value.course_title};
        $scope.parent_courses.push(obj);
      });
      
        });
     }

    $scope.getChildCourses = function(academic_id, parent_course_id){
         
        if(academic_id=='')
          return;
        
        if(parent_course_id=='')
          return ;
$scope.course_id = '';
        $scope.source_items=[];
      $scope.academic_id = academic_id;
       $scope.course_parent_id = parent_course_id;
        route = '{{URL_ACADEMICS_COURSES_GET_CHILD_COURSES}}';  
        data= {   _method: 'post', 
                  '_token':$scope.getToken(), 
                  'academic_id': academic_id, 
                  'parent_course_id': parent_course_id
              };
  httpPreConfig.webServiceCallPost(route, data).then(function(result){
    result = result.data;
        $scope.courses = [];
        angular.forEach(result, function(obj, key){
          $scope.courses_data.push(obj);
          $scope.courses.push(obj.course);  
          if(obj.course.course_dueration>1)
          {
              $scope.showCourses=true;
          }
          else 
          {
            $scope.showCourses=false; 
            $scope.course_id = obj.course.id
          }
        });
        
        first_item = $scope.courses[0];
        $scope.course_id = {'id':'', 'course_title':'Select', 'course_dueration': '', 'is_having_semister':'','course_parent_id':''};
         
        $scope.parent_selected = true;
        if(!$scope.showCourses)
        {
          
          final_records = [];
          angular.forEach($scope.courses, function(course, key){
            objectData = {
                    year:1, 
                    semister:0,
                    academic_id: course.academic_id, 
                    course_dueration: course.course_dueration,
                    course_parent_id: course.course_parent_id,
                    course_title: course.course_title,
                    id: course.id,
                    is_having_semister: course.is_having_semister
                  };
                  final_records.push(objectData);
          })
          $scope.source_items = final_records;

          
        }

        });
    }

    $scope.prepareYears = function(course){

        $scope.course_id = course;
     
        years = [];
        index = $scope.findIndexInData($scope.courses, 'id', course);
      
        total_years = $scope.courses[index].course_dueration;
        course_record = $scope.courses[index];
        course_id = course_record.id;
        
         angular.forEach($scope.courses_data, function(course, key){
            
            if(course.course.id == course_id){
               years = [];
              for(year_number =1; year_number<=total_years; year_number++){
                if(course.course.is_having_semister==0){

                    objectData = {
                    year:year_number, 
                    semister:0,
                    academic_id: course.course.academic_id, 
                    course_dueration: course.course.course_dueration,
                    course_parent_id: course.course.course_parent_id,
                    course_title: course.course.course_title,
                    id: course.course.id,
                    is_having_semister: course.course.is_having_semister
                  };

                        years.push(objectData);
                }
                else if(course.course.is_having_semister==1){
                angular.forEach(course.semister, function(semister, no){
                  if(semister.course_id==course_id && semister.year==year_number)
                  {
                    if(semister.total_semisters==0)
                    {
                      objectData = {
                    year:year_number, 
                    semister:0,
                    academic_id: course.course.academic_id, 
                    course_dueration: course.course.course_dueration,
                    course_parent_id: course.course.course_parent_id,
                    course_title: course.course.course_title,
                    id: course.course.id,
                    is_having_semister: course.course.is_having_semister
                  };

                        years.push(objectData);
                    }
                    else
                    {
                      for(semister_number = 1; semister_number<= semister.total_semisters; semister_number++)
                      {
                        
                        objectData = {
                    year:year_number, 
                    semister:semister_number,
                    academic_id: course.course.academic_id, 
                    course_dueration: course.course.course_dueration,
                    course_parent_id: course.course.course_parent_id,
                    course_title: course.course.course_title,
                    id: course.course.id,
                    is_having_semister: course.course.is_having_semister
                  };
                        years.push(objectData);
                      } 
                    }
                  }
                });
              }

                };
            }
                      
         });


        course_parent_id = course_record.course_parent_id;
        academic_id = course_record.academic_id;
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

        year = 1;
        semister = 0;
        if($scope.showCourses)
        {
          year = data.year;
          semister = data.semister;
        }
        id = '';
        id = data.academic_id+'_'+data.course_parent_id+'_'+data.id+'_'
            +year+'_'+semister;
       
        record = {  
                    'id': id,
                    'year': year,
                    'semister': semister,
                    'academic_id': data.academic_id,
                    'academic_title': data.academic_year_title,
                    'course_parent_id': data.course_parent_id,
                    'course_id': data.id,
                    'course_title': data.course_title,
                     'course_dueration': data.course_dueration,
                 };
          
          
          index = $scope.findIndexInData($scope.target_items, 'id', record.id);
          if(index==-1){
            $scope.target_items.unshift(record);
              $timeout( function(){ 

               // $scope.removeItem(data, $scope.source_items,'source_items');
             // $('#target_items-'+data.id).addClass('animated {{ANIMATION_ADD}}');
            }, 100);
              //The below method removes item from source list and resets count
        //  $scope.removeItem(data, $scope.source_items,'source_items');
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
         httpPreConfig.showConfirmation().then(function(result){
        if(result==1){

          $('#'+id+'-'+item).addClass('animated {{ANIMATION_REMOVE}}');
        $timeout( function(){ 
       
           index = $scope.findIndexInData(source, 'id', item);
        
           source.splice(index, 1);   
           if(id=='target_items')  
             alertify.success('{{getPhrase('item_removed_successfully')}}');
         }, 500);
           }

        });
     
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