/*
* @Author 	: Armel Andrianimanana
* @Email 	: arbandry@gmail.com
* @Date 	: 2020-12-14 15:04:56
* @Last Modified by:   Armel
* @Last Modified time: 2020-12-15 10:45:39
*/
$(document).ready(function(){
	if($('#_question_countdown').length){	

		let timer 		= new easytimer.Timer(); 
		let _seconds 	= parseFloat($('#countdown').val());
		
		timer.start({countdown: true, startValues: {seconds: _seconds}});
		
		$('#_question_countdown').html(timer.getTimeValues().toString());
		 
		timer.addEventListener('secondsUpdated', function (e) {
		    let _time 		= timer.getTimeValues();
		    let _hours 		= _time.hours;	
		    let _minutes 	= _time.minutes;	
		    let _secods 	= _time.seconds;	
		    if( parseInt(_hours) == 0 && parseInt(_minutes) == 0 && parseInt(_secods) < 15 )
		    	$('#_question_countdown').toggleClass('bg-danger');
		    
		    $('#_question_countdown').html(_time.toString());
		     
		});

		timer.addEventListener('targetAchieved', function (e) {
		    $('form[name=choisir_reponse]').submit();
		});
	}
});