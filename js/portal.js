
$(document).ready(function(){
	var accOpts = {
		active : true,
		heightStyle: "content",
		animated : 'bounceslide',
		collapsible: true,
		icons: { 'header': 'ui-icon-circle-arrow-e', 'headerSelected': 'ui-icon-circle-arrow-s' }
	}

	$(function() {
		$( "#catalog" ).accordion(accOpts);
		// $( "#catalog li" ).accordion()
	});

	$( "#button1" ).click(function() {
		alert( "Handler for .click() called." );
	});

	// $(function(){
	// 	$('#loginform').submit(function(e){
	// 		return false;
	// 	});

	// 	$('#modaltrigger').leanModal({ top: 110, overlay: 0.45, closeButton: ".hidemodal" });
	// });


});