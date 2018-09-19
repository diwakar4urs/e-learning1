<?php $dynamic_id = 'window_auto_height';

if(isset($newId))
	$dynamic_id = $newId;

?>
	<script>
$(document).ready(function() {
	function setHeight() {
		windowHeight = $(window).innerHeight();
		$('#{{$dynamic_id}}').css('height', windowHeight - 220);
	};
	setHeight();

	$(window).resize(function() {
		setHeight();
	});
});
</script>