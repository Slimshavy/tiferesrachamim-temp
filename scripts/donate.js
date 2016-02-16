$(document).ready(function () {

	$('#cardnumber input').val('4111 1111 1111 1111');
	$('#cvc input').val('111');
	$('#ccexp input').val('11/11');
	$('#ccname input').val('sam');

	//show donate form, hide noscript and hide recurring donation disclaimer.
	$("#donate-wrap").toggleClass("hidden");
	$("#noscript-wrap").hide();
	$("#monthly-info").hide();

	//setup braintree form
	braintree.setup($('.client-token').val(), "custom", {id: "checkout"});

	var luhnChk=function(a){return function(c){for(var l=c.length,b=1,s=0,v;l;)v=parseInt(c.charAt(--l),10),s+=(b^=1)?a[v]:v;return s&&0===s%10}}([0,2,4,6,8,1,3,5,7,9]);

	//format credit card number and cvv
	$('#cardnumber input').payment('formatCardNumber');
	$('#cvc input').payment('formatCardCVC');

	//check for errors
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

	$('#cardnumber input').focusout(function(){
 		var val = $(this).val().replace(/\s/g, '');
		
		if(!luhnChk(val))
			$(this).next().text('Please enter a valid credit card number');
		else
			$(this).next().text('');
	});

	//define regex for inputs
	var r = {
		fname: [/^[a-zA-Z]{1,50}$/,'Please enter a valid name (e.g. John)'],
		lname: [/^[a-zA-Z]{1,50}$/,'Please enter a valid name (e.g. Doe)'],
		cvc: [/^\d{3,4}$/,'Please enter a valid Security Code (e.g. 123)'],
		ccexp: [/^\d{2}\/(\d{2}|\d{4})$/,'Please enter a valid expiration date (e.g. 11/20)'],
		ccname: [/^[a-zA-Z]{1,50}( [a-zA-Z]{1,50}){1,3}$/,'Please enter a valid name (e.g. John Doe)'],
		address: [/^[a-zA-Z0-9 #-.,]{1,100}$/,'Please enter a valid address (e.g. 123 main street)'],
		city: [/^[a-zA-Z -]{1,50}$/,'Please enter a valid city (e.g. Brooklyn)'],
		state: [/^[a-zA-Z]{2}$/,'Please enter a valid state (e.g. NY)'],
		zip: [/^\d{5}$/,'Please enter a valid name (e.g. 12345)'],
		email: [/^\S{2,50}@\S{2,50}\.[a-zA-Z]{2,10}(\.[a-zA-Z]{2,10})?$/,'Please enter a valid name (e.g. info@tiferesrachamim.com)'],
		amount: [/^\d{1,5}(\.\d{2})?$/,'Please enter a valid name (e.g. 180.00)'],
	};

	$('input').focusout(function()
	{
 		var val		= $(this).val().trim();
		var name	= $(this).attr('name').trim();
		if(!r.hasOwnProperty(name)) return;

		var regex	= r[name][0];		
		var error	= r[name][1];
		//var regex = /^\d{2}\/(\d{2}|\d{4})$/;

		if(!val.match(regex))
			$(this).next().text(error);
		else
			$(this).next().text('');

		$.each(r, function(k,v)
		{
			if($('#' + k + ' input').val().match(v[0]))
				$('#' + k + ' .error-msg').text('');	
		});
	});

	/*$('#state input').focusout(function(){
 		var val = $(this).val().trim();
		var regex = /^[a-zA-Z]{2}$/;

		if(!val.match(regex))
			$(this).next().text('');
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
	});*/

    	var tz = jstz.determine(); // Determines the time zone of the browser client
    	$('.client-tz').val(tz.name());

	$("input[name=monthly]").change(function(){
		if($("input[name=monthly]:checked").val() == 'yes')
			$("#monthly-info").show();
		else
			$("#monthly-info").hide();
	});
});
