<div class="panel-heading">
		<h2>Progress Report</h2></div>
 
	
	<?php $ids=[];?>
	@for($i=0; $i<count($chart_data); $i++)
	<?php 
	$newid = 'myChart'.$i;
	$ids[] = $newid; ?>
	
	<div class="panel-body">
		<canvas id="{{$newid}}" width="100" height="110"></canvas>
	</div>

	@endfor
	 
