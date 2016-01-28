<?php
	require_once('braintree/lib/Braintree.php');

	$braintree = include('config/braintree.php');
	Braintree_Configuration::environment($braintree['environment']);
	Braintree_Configuration::merchantId($braintree['merchantId']);
	Braintree_Configuration::publicKey($braintree['publicKey']);	
	Braintree_Configuration::privateKey($braintree['privateKey']);
?>
