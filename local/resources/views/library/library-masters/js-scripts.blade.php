@include('common.angular-factory')

<script>

 app.controller('TabController', function ($scope)
  {
 $scope.printIt = function(){
  dta = $('#printable_data').html();
  $('#html_data').val(dta);
  $('#htmlform').submit();
 }
});
 
  
</script>