<?php
require_once('braintree/lib/Braintree.php');

class BraintreeHelper
{
	private static $instance;

	function __construct()
	{
		$braintree = include('config/braintree.php');
		Braintree_Configuration::environment($braintree['environment']);
		Braintree_Configuration::merchantId($braintree['merchantId']);
		Braintree_Configuration::publicKey($braintree['publicKey']);	
		Braintree_Configuration::privateKey($braintree['privateKey']);
	}

	function generateClientToken()
	{
		return Braintree_ClientToken::generate();
	}

	function donate($nonce, $info)
	{
		$result = Braintree_Transaction::sale([
	  		'amount' => $info['amount'],
	  		'paymentMethodNonce' => $nonce,
			'options' => [
			    'submitForSettlement' => True
			]
		]);

		if(!isset($result->transaction) || !$result->transaction)
			return $this->processErrors('donation', $result->errors->deepAll());

		return $this->retrieveTransactioResults($result->success, $result->transaction, $info);
	}
	
	function subscribe($nonce, $info)
	{
		$customerResult;
		$subscriptionResult;

		$customerResult = Braintree_Customer::create([
			'firstName' => $info['fname'],
			'lastName' => $info['lname'],
			'email' => $info['email'],
			'paymentMethodNonce' => $nonce,
		]);

		if (!$customerResult->success) 
			return $this->processErrors('subscription', $customerResult->errors->deepAll());

		$r = $customerResult->customer;$a = $r->addresses[0];
		$sql = 'INSERT INTO users (first_name, last_name, address, city, state, zip, braintree_customer_id, created_date, email) ';
		$sql .= "VALUES ('".$r->firstName."','".$r->lastName."','".$a->streetAddress."','".$a->locality."','".$a->region."','"
			.$a->postalCode."','".$r->id."', now(),'".$r->email."');";

		$info['userId'] = MysqlAccess::insert($sql);

		$subscriptionResult = Braintree_Subscription::create([
		  	'paymentMethodToken' => $customerResult->customer->paymentMethods[0]->token,
		  	'planId' => 'donation',
			'price' => $info['amount'],
		]);

		if(!isset($subscriptionResult->subscription) || !$subscriptionResult->subscription)
			return $this->processErrors('subscription', $subscriptionResult->errors->deepAll());
		

		return $this->retrieveSubscriptionResults($subscriptionResult->success, $subscriptionResult->subscription, $info);
	}

	function retrieveSubscriptionResults($success, $subscription, $info)
	{
		$info['braintreeSubscriptionId']	= $subscription->id;
		$info['billingDayOfMonth'] 		= $subscription->billingDayOfMonth;
		$info['planId'] 			= $subscription->planId;
		$info['price'] 				= $subscription->price;
		$info['status'] 			= $subscription->status;
		$info['subscription'] 			= 1;

		$i = $info; $s = $subscription;
		$sql = 'INSERT INTO subscriptions (user_id, plan_name, price, status, braintree_subscription_id, date_created) ';
		$sql .= "VALUES ('".$i['userId']."','".$s->planId."',".$s->price.",'".$s->status."','".$s->id."', now());";

		MysqlAccess::insert($sql);

		return $this->retrieveTransactioResults($success, $subscription->transactions[0], $info);
	}
	function retrieveTransactioResults($success, $transaction, $info)
	{
		$card = $transaction->creditCard;//last4, debit, prepaid

		$info['authCode'] 		= $transaction->processorAuthorizationCode;
		$info['success'] 		= $success;
		$info['message']		= '';
		$info['header'] 		= '';
		$info['paymentType']		= 'Credit card';
		$info['gatewayRejectReason'] 	= $transaction->gatewayRejectionReason;
		$info['transStatus'] 		= $transaction->status;
		$info['processorResponseCode']	= $transaction->processorResponseCode;
		$info['resultAmount'] 		= $transaction->amount;
		$info['last4'] 			= $card['last4'];
		$info['cardType'] 		= $card['cardType'];
		$info['cardHolderName'] 	= $card['cardholderName'];

		$transDate 			= $transaction->createdAt;
		$info['serverTransDate'] 	= $transDate->format('Y-m-d H:i:s');
		$transDate->setTimezone(new DateTimeZone($_POST['client-tz']));
		$info['clientTransDate'] 	= $transDate->format('n/j/Y g:i A');

		if(strtolower($card['debit']) == 'yes')
			$info['paymentType'] = 'Debit card';

		else if(strtolower($card['prepaid']) == 'yes')
			$info['paymentType'] = 'Prepaid card'; 

		$sql = 'INSERT INTO donations (cardholder_name,	result_amount, request_amount, email, payment_type, card_type, trans_status,
				processor_response_code,trans_date,gateway_reject_reason,last4, subscription_id) ';
		$sql .= "VALUES ('".$info['cardHolderName']."', ".$info['resultAmount'].", ".$info['amount'].", '".$info['email']."', '".$info['paymentType']."',
 				'".$info['cardType']."', '".$info['transStatus']."', ".$info['processorResponseCode'].", '".$info['serverTransDate']."',
				'".$info['gatewayRejectReason']."', '".$info['last4']."', ".(isset($info['subscriptionId'])?$info['subscriptionId']:0).");";

		$info['confirmationNumber'] = MysqlAccess::insert($sql);

		if ($info['success'])
		{
			$info['header'] = 'Thank you for your donation!';
			$info['message'] = "Your donation has been succesfully processed. Thank you for helping us help you.";
		}
		else
		{
			$info['header'] = 'There was a problem processing your request';

			if ($info['transStatus'] == 'gateway_rejected')
				$info['message'] = $this->getGatewayRejectMessagee($info['gatewayRejectReason']);

			else if ($info['transStatus'] == 'processor_declined')
				$info['message'] = $this->getProcessorRejectMessagee($info['processorResponseCode']);

			else
				$info['message'] = "The transaction was declined due to an unknown reason. Please contact your merchant for more information.";
		}
		
		return $info;
	}

	private function getProcessorRejectMessagee($error)
	{
		if ($error == 2004)
			return "The card provided is expired. Please try again with a different card.";

		if ($error == 2005)
			return "The card number provided is invalid. Please try again.";		

		if ($error == 2006)
			return "The Expiration Date provided was invalid. Please try again.";		

		if ($error == 2010)
			return "Your bank was not able to validate the Security code. Please try again.";

		return "The transaction was declined due to an unknown reason. Please contact your bank for more information.";
	}

	private function getGatewayRejectMessagee($error)
	{
		if ($error == 'avs')
			return "Your bank was not able to validate the Billing Information. Please try again.";

	 	if ($error == 'fraud')
			return "Your transaction was rejected due to suspected fraudulant activities.";

		if ($error == 'cvv')
			return "Your bank was not able to validate the Security code. Please try again.";

		return "The transaction was declined due to an unknown reason. Please contact the shul for more information.";
	}

	private function processErrors($source, $errors)
	{
		$description = 'There was an error creating a '.$source.': ';
		foreach($errors AS $error) 
		{
			$description .= $error->code." ";
		}
		
		MysqlAccess::log($description);

		return [
			'header' => 'Sorry! We had a problem', 
			'message'=>'There was an error with the '.$source.'. Please try again later.',
			'success' => '',
		];
	}

	public static function getInstance()
	{
		if(static::$instance === null)
			static::$instance = new BraintreeHelper();
	
		return static::$instance;
	}
}
?>
