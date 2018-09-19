<?php 
$settings = json_decode($module_helper->settings);
$steps = $module_helper->steps;

?>  
 <script >

    // Instance the tour
var tour = new Tour({
  debug: false,
  storage: false,
  keyboard: <?php echo $settings->keyboard;?>,
  backdrop: <?php echo $settings->backdrop;?>,
  template: "<div class='popover tour helper-popover'>"
    +"<div class='arrow'></div>"
    +"<h3 class='popover-title'></h3>"
    +"<div class='popover-content'></div>"
  +'<div class="popover-navigation">'
  +'<div class="btn-group">'
  +'<button class="btn btn-sm btn-primary" data-role="prev"  tabindex="-1">« Prev</button> <button class="btn btn-sm btn-primary" data-role="next">Next »</button>  </div> &nbsp;<button class="btn btn-sm btn-danger" data-role="end">End tour</button> </div>',


  @if($steps)
  steps:  <?php echo $steps;?>
  @endif
});

 
function startTour() {
if (tour.ended()) {
  tour.restart();
} else {
  tour.init();
  tour.start();
}
}
 </script>