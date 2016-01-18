alert("test");
$(document).ready(function () {
	alert('test1');
	$('.card-number').change(function (e) {
		alert('test2');
  		$('.card-number').text( $('.card-number').text().replace(/(.{4})/g, '$1 ').trim());
	});
};
