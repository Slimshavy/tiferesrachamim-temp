<?php
	require_once('helpers/BraintreeHelper.php');

	if(!isset($_POST['payment_method_nonce']))
	{
		?>
		<div class="wrap">
		  <p> An error occured while submitting your request. If JavaScript is disabled, please enable it it and try again. </p>
		  <a href='/donate' class='btn'> Return to donate page </a>
  		</div>
		<?php
		exit();
	}

	$nonce = $_POST['payment_method_nonce'];
	$amount = $_POST['amount'];
	$email = $_POST['email'];
	$fname = $_POST['fname'];
	$lname = $_POST['lname'];

	$emailPattern = '/^\S{2,}@\S{2,}\.[a-zA-Z]{2,10}(\.[a-zA-Z]{2,10})?$/';
	$amountPattern = '/^\d{1,5}(\.\d{2})?$/';
	$namePattern = '/[a-zA-Z]{1,50}/';

	if(preg_match($emailPattern, $email) == false || preg_match($amountPattern, $amount) == false ||
		preg_match($namePattern, $fname) == false || preg_match($namePattern, $lname) == false)
	{
		ob_end_clean();
	 	header('Location: /donate'); 
		exit();
	}
	
	$result; //test info = require_once('include/test/resultInfo.php');

	$info = ['amount'=>$amount, 'email'=>$email, 'fname'=>$fname, 'lname'=>$lname];

	if ($_POST['monthly'] == 'yes')
		$result = BraintreeHelper::getInstance()->subscribe($nonce, $info);

	else
		$result = BraintreeHelper::getInstance()->donate($nonce, $info);
?>
	<h1><?php echo $result['header']; ?></h1>
	<?php if (!$result['success']){echo '<h2>'.$result['message'].'</h2>'; } ?> 

	<div class="wrap">
<?php
	if ($result['success'])
	{
?>
	<h2><?php echo $result['message']; ?></h2>
	<div class="vals-wrapper">
            <span class='lbl'>Confirmation Number</span>
            <span class='val'><?php echo $result['confirmationNumber']; ?></span>
            <div class="clear"></div>

	    <span class='lbl'>Name</span>
            <span class='val'><?php echo ucwords(ucwords($fname.' '.$lname)); ?></span>
            <div class="clear"></div>

            <span class='lbl'>Amount</span>
            <span class='val'>$<?php echo $result['resultAmount']; ?></span>
            <div class="clear"></div>

            <span class='lbl'>Date</span>
            <span class='val'><?php echo $result['clientTransDate']; ?></span>
            <div class="clear"></div>

            <span class='lbl'>Authorization Code</span>
            <span class='val'><?php echo $result['authCode']; ?></span>
            <div class="clear"></div>

            <span class='lbl'>Payment Type</span>
            <span class='val'><?php echo ucwords(ucwords($result['paymentType'])); ?></span>
            <div class="clear"></div>

            <span class='lbl'>Card Type</span>
            <span class='val'><?php echo ucwords(ucwords($result['cardType'])); ?></span>
            <div class="clear"></div>

            <span class='lbl'>Last 4 of Account Number</span>
            <span class='val'><?php echo $result['last4']; ?></span>
            <div class="clear"></div>
         </div>
<?php
	}

	if (isset($result['subscription']))
	{
?>
	<div class="vals-wrapper subscription-wrapper">
	    <p>
 	       You have agreed to recurring charges on a monthly basis. You may call Laibie at (347) 403-1660 to cancel the recurring charges at any time. 
	       Please review the information below and contact Laibie immediately if the information is incorrect.
	    </p>
            <span class='lbl'>Recuring Subscription ID</span>
            <span class='val'><?php echo $result['braintreeSubscriptionId']; ?></span>
            <div class="clear"></div>

	    <span class='lbl'>Recuring Amount</span>
            <span class='val'>$<?php echo $result['price']; ?></span>
            <div class="clear"></div>

            <span class='lbl'>Recuring Day of Month</span>
            <span class='val'><?php echo $result['billingDayOfMonth']; ?></span>
            <div class="clear"></div>

            <span class='lbl'>Recuring Subscription Status</span>
            <span class='val'><?php echo ucwords(ucwords($result['status'])); ?></span>
            <div class="clear"></div>
         </div>
<?php
	}
?>
         </div>

         <a onclick='window.print();' class='btn'>Print</a>
	 <a href='/donate' class='btn'>Return to donate page</a>
