<?php
	ini_set('display_errors','On');
	require_once('braintree-php/lib/Braintree.php');
	Braintree_Configuration::environment('sandbox');
	Braintree_Configuration::merchantId('bqzx377yfynks9qy');
	Braintree_Configuration::publicKey('s23nfwb3gy3p3cvn');	
	Braintree_Configuration::privateKey('7c65920f12d1385782dd6782ff10acaf');
	
	if($_GET['type'] == 'token')
	{
  		die( Braintree_ClientToken::generate());
	}
?>
