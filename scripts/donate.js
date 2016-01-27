$(document).ready(function () {

	braintree.setup($('.client-token').val(), "custom", {id: "checkout"});

	$('.card-number').payment('formatCardNumber');
	$('.expiration').payment('formatCardExpiry');
	$('.cvv').payment('formatCardCVC');



    	var tz = jstz.determine(); // Determines the time zone of the browser client
    	$('.client-tz').val(tz.name()); //'Asia/Kolhata' for Indian Time.


	/*$('.card-number').keypress(function (e) {
  		$('.card-number').val( $('.card-number').val().replace(/\s/g, '').replace(/(.{4})/g, '$1 ').trim());
	});

	$('.card-number').validateCreditCard(function(result){
		$('#errors').text(result.toString());
	});*/
});
