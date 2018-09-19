<script src="{{JS}}angular.js"></script>
<script>

 var app = angular.module('academia',[]);
     app.controller('lessionPlanController', function ($scope, $http) {
      
     $scope.topics = [];
      $scope.available_items = [];
    
      search='';
      /**
       * This method intilize the default data to allocated courses and available courses
       * @param  {[type]} data [description]
       * @return {[type]}      [description]
       */
      $scope.ingAngData = function(data) {
          angular.forEach(data.topics,function(value,key){
            $scope.topics.push(value);
         });

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

        $scope.updateTopic = function(topicId, courseSubjectsId, status){
         
          
            route = '{{URL_LESSION_PLANS_UPDATE_TOPIC}}';  
          data= {
                _method   : 'post', 
                '_token'  : $scope.getToken(), 
                'topic_id': topicId, 
                'course_subject_id': courseSubjectsId, 
                'status'  : status
              };

          $http.post(route, data).success(function(result, status) {
            if(result.status==1){
              $scope.topics = [];
              angular.forEach(result.topics,function(value,key){
                $scope.topics.push(value);
              });
              alertify.success('{{getPhrase('record_updated_successfully')}}');  
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


  });

     app.filter('capitalize', function() {
    return function(input) {
      return (!!input) ? input.charAt(0).toUpperCase() + input.substr(1).toLowerCase() : '';
    }
});

</script>
