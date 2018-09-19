@include('common.angular-factory')

<script >
app.controller('ModuleHelper', function($scope, $http, httpPreConfig) { 
    $scope.placements = [
                       {value:'right', text:'Right'},
                       {value:'left',  text:'Left'},
                       {value:'top',  text:'Top'},
                       {value:'bottom',  text:'Bottom'},
                      ];
$scope.selected_placement = $scope.placements[0];
$scope.target_items = [];
$scope.sort_order=1;

$scope.initData = function (data)
{
  $scope.target_items = [];
  if (typeof(data) != "undefined")
    $scope.target_items = data;
  

  
}
$scope.addToList = function()
{
  element = $scope.element;
  title = $scope.title;
  placement = $scope.selected_placement.value;
  content = $scope.content;
  sort_order = $scope.sort_order;
  id = Date.now()

  object = {id:id,element: element, title:title, placement:placement, content:content, sort_order: sort_order};
  console.log(object);
  $scope.target_items.push(object);
  
  $scope.resetForm();
}

$scope.resetForm = function(){
  $scope.element = '';
  $scope.title = '';
  $scope.content = '';
  $scope.sort_order=1;

}

$scope.removeItem = function(item){
   httpPreConfig.showConfirmation().then(function(result){
        if(result==1){
    index = httpPreConfig.findIndexInData($scope.target_items, 'id', item.id);
           $scope.target_items.splice(index, 1);  
         }
       });
}
});
app.filter('orderObjectBy', function(){
 return function(input, attribute) {
    if (!angular.isObject(input)) return input;

    var array = [];
    for(var objectKey in input) {
        array.push(input[objectKey]);
    }

    array.sort(function(a, b){
        a = parseInt(a[attribute]);
        b = parseInt(b[attribute]);
        return a - b;
    });
    return array;
 }
});
</script>

