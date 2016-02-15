$(document).ready(function () {

$('#card-number input').val('4111 1111 1111 1111');
$('#cvv input').val('111');
$('#expiration input').val('11/11');
$('#card-name input').val('sam');
	$("#donate-wrap").toggleClass("hidden");
	$("#noscript-wrap").hide();
	$("#monthly-info").hide();

	var luhnChk=function(a){return function(c){for(var l=c.length,b=1,s=0,v;l;)v=parseInt(c.charAt(--l),10),s+=(b^=1)?a[v]:v;return s&&0===s%10}}([0,2,4,6,8,1,3,5,7,9]);

	braintree.setup($('.client-token').val(), "custom", {id: "checkout"});

	$('#card-number input').payment('formatCardNumber');
	$('#cvv input').payment('formatCardCVC');

	$('.profile__form #submit').click(function(){
		var bad = false;
		
		$('.error-msg').each(function(index){
			bad = bad || $(this).text().trim().length > 0;
		});
		if(bad)
		{
			$('.error-msg').animate({fontSize:'150%'},50);
			$('.error-msg').animate({fontSize:'100%'},50);
			return false;
		}
		return true;
	});

	$('#card-number input').focusout(function(){
 		var val = $(this).val().replace(/\s/g, '');
		
		if(!luhnChk(val))
			$(this).next().text('Please enter a valid credit card number');
		else
			$(this).next().text('');
	});

	$('#expiration input').focusout(function(){
 		var val = $(this).val().trim();
		var regex = /^\d{2}\/(\d{2}|\d{4})$/;

		if(!val.match(regex))
			$(this).next().text('Please enter a valid expiration date (e.g. 11/20)');
		else
			$(this).next().text('');
	});

	$('#state input').focusout(function(){
 		var val = $(this).val().trim();
		var regex = /^[a-zA-Z]{2}$/;

		if(!val.match(regex))
			$(this).next().text('Please enter a valid state (e.g. NY)');
		else
			$(this).next().text('');
	});

	$('#postal input').focusout(function(){
 		var val = $(this).val().trim();
		var regex = /^\d{5}$/;

		if(!val.match(regex))
			$(this).next().text('Please enter a valid zip code (e.g. 11213)');
		else
			$(this).next().text('');
	});

	$('#email input').focusout(function(){
 		var val = $(this).val().trim();
		var regex = /^\S{2,}@\S{2,}\.[a-zA-Z]{2,10}(\.[a-zA-Z]{2,10})?$/;

		if(!val.match(regex))
			$(this).next().text('Please enter a valid email (e.g. info@tiferesrachamim.com)');
		else
			$(this).next().text('');
	});

	$('#amount input').focusout(function(){
 		var val = $(this).val().trim();
		var regex = /^\d{1,5}(\.\d{2})?$/;

		if(!val.match(regex))
			$(this).next().text('Please enter a valid amount (e.g. 180.00)');
		else
			$(this).next().text('');
	});

    	var tz = jstz.determine(); // Determines the time zone of the browser client
    	$('.client-tz').val(tz.name());

	$("input[name=monthly]").change(function(){
		if($("input[name=monthly]:checked").val() == 'yes')
			$("#monthly-info").show();
		else
			$("#monthly-info").hide();
	});
});
