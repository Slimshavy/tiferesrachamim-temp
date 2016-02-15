
	function joinWhatsApp()
	{
		var val = $('#whatsapp-phone').val().replace(/[ ()-]/gi,'').trim();
		var regex = /^\d{10}$/;

		if(!val.match(regex))
		{
			alert('Invalid phone number. Please enter a 10 digit phone number.');
		}
		else
		{
			$.post('/joinwhatsapp',{phone: val}, function(data){
				if(data.successful)
					$('#whatsapp').text('Thank you for joining');
				else
					alert('We were unable to submit your request. Please try again later');
			});
		}
	}

