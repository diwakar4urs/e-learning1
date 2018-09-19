<script src="{{JS}}angular.js"></script>

 <script src="{{JS}}angular-messages.js"></script>

 <script >
  var app = angular.module('academia', ['ngMessages']);
</script>

@include('common.angular-factory',array('load_module'=> FALSE))

<?php 
            $start_time = getSetting('start_time','time_table');
            $end_time = getSetting('end_time','time_table');
           
?>

<script>
 

app.controller('timigsetController', function( $scope, $http, httpPreConfig) {
  $scope.timeset = [];
 
  times = [];
    for(hours = 6; hours<=20; hours++)
    {
      for(interval=0; interval<60; interval +=5)
      {
        var padded_hours = hours+"";
        while (padded_hours.length < 2) padded_hours = "0" + padded_hours;
      
        var padded_interval = interval+"";
        while (padded_interval.length < 2) padded_interval = "0" + padded_interval;

        temp = {
                'value': padded_hours+':'+padded_interval+':00', 
                'text' : padded_hours+':'+padded_interval+':00'
                }
        times.push(temp);
      }
    }


    $scope.timeset = times;
    
    $scope.default_start_time = '{{$start_time}}:00:00';
    $scope.default_end_time = '{{$end_time}}:00:00';
    
    $scope.source = {name:'',end_time:$scope.default_end_time, start_time:$scope.default_start_time, is_break:false};  
      
     
    $scope.target_items = [];
    $scope.selected_start_times = [];
    $scope.selected_end_times = [];
    $scope.intilizeData = function(data){
 
      list = [];

      angular.forEach(data, function(value, key){
       
        dta = {id:value.id,name: value.period_name, start_time: value.start_time, end_time: value.end_time, is_break: value.is_break};
       list.push(dta);
        start_time_object = {
                'value': value.start_time, 
                'text' : value.start_time
                }
        end_time_object = {
                'value': value.end_time, 
                'text' : value.end_time
                }
        $scope.selected_start_times.push(start_time_object);
        $scope.selected_end_times.push(end_time_object);

      })

      $scope.target_items = list;
    }
    
 
    $scope.addToList = function (item) {
      
      if(!$scope.validateItem(item))
        return;

      
    
        start_time_object = {
                'value': item.start_time, 
                'text' : item.start_time
                }
        end_time_object = {
                'value': item.end_time, 
                'text' : item.end_time
                }
        $scope.selected_start_times.push(start_time_object);
        $scope.selected_end_times.push(end_time_object);
       
      $scope.target_items.push(item);
      
      $scope.source = {name:'',end_time:$scope.default_end_time,start_time:item.end_time,is_break:false};  
    }

    /**
     * This method validates the input given to time sets
     * @param  {[type]} item [description]
     * @return {[type]}      [description]
     */
    $scope.validateItem = function(item) {
      error_message = '';
      error = false;
      //Name cannot be empty
      if(item.name=='')
      {
        error_message = '{{getPhrase("enter_period_name")}}';
        error = true;
      }

      if(error)
      {
        alertify.error(error_message);
        return false;
      }

      return true;
    }


    $scope.editItem = function(item){
      index = httpPreConfig.findIndexInData($scope.target_items, 'id', item.id);
      $scope.source.name = item.name;
      $scope.source.start_time = item.start_time;
      $scope.source.end_time = item.end_time;
    }

    $scope.removeItem = function(item, source, id) { 
        httpPreConfig.showConfirmation().then(function(result){
        if(!result)
          return;
        route = '{{URL_TIMINGSET_RECORD_DELETE}}'+item.id;  
        data= {_method: 'delete', '_token':httpPreConfig.getToken()};
         httpPreConfig.webServiceCallPost(route, data).then(function(result){
          result = result.data;
          if(result.status==1){
            $('#'+id+'-'+item.id).addClass('animated {{ANIMATION_REMOVE}}');
            result = result.data;
            $scope.parent_courses = result;

          var index = source.indexOf(item);
           index = httpPreConfig.findIndexInData(source, 'id', item.id);
           source.splice(index, 1);   
           if(id=='target_items')  
             alertify.success('{{getPhrase('item_removed_successfully')}}');

          }
          else{
              alertify.error(result.message);                    
          }

          
        });


          });
        }

    /**
     * This method will verify the validity of end time
     * @param  {[type]} item [description]
     * @return {[type]}      [description]
     */
    $scope.getEndTime = function (item) {
      if($scope.target_items.length==0)
        return true;

      endtime = item.start_time;
      
      angular.forEach($scope.target_items, function(value, key) {
        endtime = value.end_time;
      });

      if(endtime <= parseInt(item.start_time))
        return true;
    return false;
    }


 });

</script>

 