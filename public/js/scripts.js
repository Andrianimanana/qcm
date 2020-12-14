/*
* @Author: Armel Andrianimanana
* @Date:   2020-12-14 15:04:56
* @Last Modified by:   Armel
* @Last Modified time: 2020-12-14 15:38:56
*/
$(document).ready(function(){
	if($('#_question_countdown').length){	

		let timer 		= new easytimer.Timer(); 
		let _seconds 	= parseFloat($('#countdown').val());
		
		timer.start({countdown: true, startValues: {seconds: _seconds}});
		
		$('#_question_countdown').html(timer.getTimeValues().toString());
		 
		timer.addEventListener('secondsUpdated', function (e) {
		    const _time = timer.getTimeValues();
		    if(_time.seconds < 15)
		    	$('#_question_countdown').toggleClass('bg-danger');
		    
		    $('#_question_countdown').html(_time.toString());
		     
		});

		timer.addEventListener('targetAchieved', function (e) {
		    $('form[name=choisir_reponse]').submit();
		});
	}
});