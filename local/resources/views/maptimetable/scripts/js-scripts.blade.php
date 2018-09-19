<script src="{{JS}}angular.js"></script>
<script src="{{JS}}plugins/dragdrop/ngDraggable.js"></script>
<script>

 var app = angular.module('academia', ['ngDraggable']);
     app.controller('MapTimingsetController', function ($scope, $timeout) {
      
     $scope.source_items = [];
      $scope.target_items = [];
      
      search='';
      /**
       * This method intilize the default data to allocated source_items and available source_items
       * @param  {[type]} data [description]
       * @return {[type]}      [description]
       */
     	$scope.initAngData = function(data) {
        // console.log(data);
         angular.forEach(data.source_items,function(value,key){
            $scope.source_items.push(value);
         });
         angular.forEach(data.target_items,function(value,key){
            $scope.target_items.push(value);
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
        
        res = $scope.findIndexInData($scope.target_items, 'id', data.id);
          if(res==-1){
            $scope.target_items.push(data);
              $timeout( function(){ 
              $('#target_items-'+data.id).addClass('animated bounceIn');
            }, 100);
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
      $scope.removeItem = function(item) { 
          $('#target_items-'+item.id).addClass('animated bounceOutDown');
        $timeout( function(){ 
          var index = $scope.target_items.indexOf(item);
           index = $scope.findIndexInData($scope.target_items, 'id', item.id);
           $scope.target_items.splice(index, 1);     
             alertify.success('{{getPhrase('item_removed_successfully')}}');
         }, 500);
            
             
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
