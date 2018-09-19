<script src="{{JS}}angular.js"></script>
<script src="{{JS}}plugins/dragdrop/ngDraggable.js"></script>
<script>

 var app = angular.module('academia', ['ngDraggable']);
     app.controller('academicCourses', function ($scope, $timeout) {
      
     $scope.source_items = [];
      $scope.target_items = [];
      $scope.target_items_subjects = $scope.target_items.length;
      $scope.target_items_labs = 0;
      $scope.target_items_electives = 0;
      
      search='';
      /**
       * This method intilize the default data to allocated courses and available courses
       * @param  {[type]} data [description]
       * @return {[type]}      [description]
       */
     	$scope.ingAngData = function(data) {
         angular.forEach(data.target_items,function(value,key){
            $scope.target_items.push(value);
         });

         angular.forEach(data.source_items,function(value,key){
          res = $scope.findIndexInData($scope.target_items, 'id', value.id);
          if(res==-1)
            $scope.source_items.push(value);
         });
         

         $scope.resetCount();
     	}
       
      $scope.resetCount = function() {
        labs=0;
        electives = 0;

           angular.forEach($scope.target_items,function(value,key){
            if(value.is_lab)
              labs++;
            if(value.is_elective_type)
              electives++;
         });
           $scope.target_items_labs =labs;
           $scope.target_items_electives = electives;
              $scope.target_items_subjects = $scope.target_items.length;
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
 
        res = $scope.findIndexInData($scope.target_items, 'id', data.id);
          if(res==-1){
            $scope.target_items.unshift(data);
              $timeout( function(){ 
              $('#target_items-'+data.id).addClass('animated {{ANIMATION_ADD}}');
            }, 100);
              //The below method removes item from source list and resets count
          $scope.removeItem(data, $scope.source_items,'source_items');
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
      $scope.removeItem = function(item, source, id) { 
          $('#'+id+'-'+item.id).addClass('animated {{ANIMATION_REMOVE}}');
        $timeout( function(){ 
          var index = source.indexOf(item);
           index = $scope.findIndexInData(source, 'id', item.id);
           source.splice(index, 1);   
           if(id=='target_items')  
             alertify.success('{{getPhrase('item_removed_successfully')}}');
         }, 500);
        
        //Push the removed items to source list     
        if(id=='target_items') {
           res = $scope.findIndexInData($scope.source_items, 'id', item.id);
           if(res==-1)
              $scope.source_items.unshift(item);
        }

          $scope.resetCount();
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
