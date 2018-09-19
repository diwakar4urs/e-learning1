var app = angular.module('academia', []);
app.controller('angExamScript', function($scope, $http) {
	
	$scope.initAngData = function(data) {
		if(data=='')
		{
			return;
		}
	$scope.hints = 0;	 
	}
});

/**
 * General Exam Scripts
 * Variables used in the below script
 */
var EFFECT 							= 'bounceInDown';
var DURATION 						= 500;
var DIV_REFERENCE 					= $("#questions_list .question_div");
var MAXIMUM_QUESTIONS 				= $("#questions_list .question_div").size();
var VISIBLE_ELEMENT 				= "#questions_list .question_div:visible";
var HINTS 							= 0;
var ANSWERED 						= ' answered';
var NOT_ANSWERED 					= ' not-answered';
var ANSWER_MARKED 					= ' marked';
var NOT_VISITED 					= ' not-visited';
var TOTAL_ANSWERED 					= 0;
var TOTAL_MARKED 					= 0;
var TOTAL_NOT_VISITED 				= MAXIMUM_QUESTIONS;
var TOTAL_NOT_ANSWERED 				= MAXIMUM_QUESTIONS;
var HOURS 							= 0;
var MINUTES							= 0;
var SECONDS							= 0;



DIV_REFERENCE.first().show();
updateCount();
 
// onlclick of next button
$('.next').click(function() { 
	
	is_marked = 0;
	if($(this).attr('id') == 'markbtn')
		is_marked = 1;

	processNext(is_marked);
	 $(VISIBLE_ELEMENT).next('div').slideDown(DURATION).prev().hide();
	doGeneralOperations();
    return false;
});    

// onlclick of prev button
$('.prev').click(function() { 
	$(VISIBLE_ELEMENT).prev('div').slideDown(DURATION).next().hide();
	doGeneralOperations();
	return false;
});

$('.clear-answer').click(function() {
	list = $(VISIBLE_ELEMENT + ' input ');
	$.each( list, function() {
    	elementType = $(this).attr('type');
    	switch(elementType) {
    		case 'radio': $(this).prop('checked', false); break;
    		case 'checkbox': $(this).attr('checked', false); break;
			case 'text': $(this).val(''); break;
    	}
    	 
	});
	
});

/**
 * The below method will determine the input elements and accordingly
 * update the status of palete and count of palete based on the event generated
 * @param  {Boolean} is_marked [is true if user clicks for mark for review button]
 * @return {[type]}            [description]
 */
function processNext(is_marked) {
	
	/**
	 * Get all the elements of type input
	 */
	list = $(VISIBLE_ELEMENT + ' input ');
	
	/**
	 * Get all the elements of type text area
	 */
	textarea_list =  $(VISIBLE_ELEMENT + ' textarea ');
	
	// This is the global flag to determine wether the user is answered or skipped this question
	answer_status = 0;
	
	//Process input type of elements in foreach loop
	if(list!=0) {
		list.each(function(index, value){

			element_type = $(value).attr('type');
			
			switch(element_type)
			{
				case 'radio': if($(value).prop('checked')) answer_status = 1; break;
				case 'checkbox': if($(value).prop('checked')) answer_status = 1; break;
				case 'text': if($(value).val().length != 0) answer_status = 1; break;
			}
		});
	}
	
	//Process textarea type of elements in foreach loop
	if(textarea_list.length)
	{
	   textarea_list.each(function(index, value){
		 if($(value).val().length!=0)
				answer_status = 1;
		});
	}

	//Assign the appropriate clase based on the answer type
	class_name = NOT_ANSWERED;
	if(answer_status) {
		if(is_marked)
			class_name = ANSWER_MARKED;
		else
			class_name = ANSWERED;
	}
	
	//Update the palette with status
	$(".question-palette .pallete-elements:eq("+getCurrentIndex()+")")
	.removeClass(NOT_VISITED + NOT_ANSWERED + ANSWER_MARKED)
	.addClass(class_name);
	return false;
}

/**
 * The below method keeps eye on the index of questions and hides/shows the next and previous buttons
 * @return {[void]} [description]
 */
function checkButtonStatus() {
	CURR_INDEX = getCurrentIndex()+1;
	
	if(CURR_INDEX == MAXIMUM_QUESTIONS)
	{
		$('.next').slideUp();
		$('.prev').slideDown();
	}
	else if(CURR_INDEX == 1)
	{
		$('.prev').slideUp();
		$('.next').slideDown();
	}
	else 
	{
		$('.next').show();
		$('.prev').show();
	}
}

/**
 * The below method contains all common operations to perform after an event has generated
 * @return {[type]} [description]
 */
function doGeneralOperations() {
	setQuestionNumber();
	checkButtonStatus();
	updateCount();
	return false;
}

/**
 * This method returns the current visible div index;
 * @return {[type]} [description]
 */
function getCurrentIndex() {
	return $(VISIBLE_ELEMENT).index();
}

/**
 * This method is used to show the specific based on the provided index value
 * @param  {[type]} index [description]
 * @return {[type]}       [description]
 */
function showSpecificQuestion(index) {
	$(VISIBLE_ELEMENT).hide();
	$("#questions_list .question_div:eq("+index+")").slideDown();
	doGeneralOperations();
	return false;
}

/**
 * This method is used to update the overall summary of the palletes.
 * @return {[type]} [description]
 */
function updateCount() {
	TOTAL_NOT_ANSWERED 	= $(".not-answered").length - 1;
	TOTAL_NOT_VISITED 	= $(".not-visited").length - 1;
	TOTAL_MARKED 		= $(".marked").length - 1;
	TOTAL_ANSWERED 		= $(".answered").length - 1;
	$('#palette_total_answered').html(TOTAL_ANSWERED);
	$('#palette_total_marked').html(TOTAL_MARKED);
	$('#palette_total_not_visited').html(TOTAL_NOT_VISITED);
	$('#palette_total_not_answered').html(TOTAL_NOT_ANSWERED);
}

$('.finish').click(function() { 

	
});

/**
 * This method is used to track the question no to show it on serial no.
 */
function setQuestionNumber() {
	$('#question_number').html(getCurrentQuestionNumber());
}

/**
 * This method is used to fetch the current question no.
 * @return {[type]} [description]
 */
function getCurrentQuestionNumber() {
	return $(VISIBLE_ELEMENT).index()+1;
}


	// function testAnim(current_element, x) {
	// 	console.log(current_element);
	// 	// $('#questions_list .question_div').removeClass(x + ' animated');
	// $(current_element).addClass(x + ' animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
	//    // $(current_element).removeClass(x + 'animated');
	// });
	// return false;
	// } 

	function intilizetimer(hrs, mins, sec)
	 {
	 	HOURS 		= hrs;
	 	MINUTES 	= mins;
	 	SECONDS 	= sec;
	 	$("#timerdiv").addClass('text-success');
	 	startInterval();
	 } 
	 function startInterval()
	 {

		timer= setInterval("tictac()", 1000);
	 }
	
	function stopInterval()
	{
		clearInterval(timer);
	} 

	 function tictac(){
   			SECONDS--;
   			
   			if(SECONDS<=0)
   			{
   				MINUTES--;
   				// $("#timerdiv #mins span").text(MINUTES);
   				$("#mins").text(MINUTES);
   				if(MINUTES<1)
   				{
   					$("#timerdiv").removeClass('text-success');
   					$("#timerdiv").addClass("text-red");
   				}
   				
   				
   				
   				if(MINUTES<0)
   				{
   					stopInterval();
   					$("#mins").text('0');
   					// $("#timerdiv #mins span").text('0');
   					  alert('You are exceeded the time to finish the exam.');
   					// swal({   title: "Timeup!",   text: "You are exceeded the time to finish the exam",   timer: 5000,   showConfirmButton: true });
    
 
   					$('#onlineexamform').submit();
 
   				}
   				
   					
   				SECONDS=60;
   			}
   			
   			if(MINUTES>=0)
   			$("#seconds").text(SECONDS);
   			else
   			$("#seconds").text('00');
   		}  
  
  

	