<div id="myCarousel" class="carousel slide id-cards-slider" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    <li data-target="#myCarousel" data-slide-to="1"></li>
    
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
    <div class="item active">
    <h3 class="text-primary">{{getPhrase('default_theme')}}</h3>
      <img src="{{IMAGES}}theme-default.png" alt="Theme default">
    </div>

    <div class="item">
    <h3 class="text-primary">{{getPhrase('green_theme')}}</h3>
      <img src="{{IMAGES}}theme-green.png" alt="Theme green">
    </div>

    <div class="item">
    <h3 class="text-primary">{{getPhrase('red_theme')}}</h3>
      <img src="{{IMAGES}}theme-red.png" alt="theme red">
    </div>
  </div>

  <!-- Left and right controls -->
  <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>