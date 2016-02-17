<?php
	$controller = array(
		'title' => 'Donate',
		'view' => 'donate',
		'styles' => array('donate'),
		'scripts' => array('jquery','timezonedetector','jquery.payment.min','donate','braintree')
	);
	
	if($config['devlopment'] == true)
		$controller['scripts'][] = 'donatetest';

	return $controller;
?>
