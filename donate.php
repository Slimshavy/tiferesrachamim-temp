<html>
	<head>
		<title> Tiferes Rachamim - Donate</title>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script src="https://js.braintreegateway.com/v2/braintree.js"></script>
	        <script src="http://localhost/js/index.js"></script>
		<link rel="stylesheet" type="text/css" href="styles/checkout.css">

		<script>
			$.get('payment.php?type=token',function(data){
 				braintree.setup(data, "custom", {id: "checkout"});
			});
		</script>
	</head>

	<body>


	<div class="container">
		<div class="profile">
			<form id="checkout" action="checkout.php" method="post" class="profile__form">
				<div class="profile__fields">

				  	<input class="input card-number" data-braintree-name="number" placeholder="Credit Card Number" maxLength="19" 							onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="4111111111111111">

			  		<input class="input cvv" data-braintree-name="cvv" placeholder="Security Code" value="100">
				  	<input class="input expiration" data-braintree-name="expiration_date" placeholder="Expiration: mm/yy" value="10/20">

				  	<input class="input " data-braintree-name="cardholder_name" placeholder="Cardholder Name" value="John Smith">
				  	<input class="input" data-braintree-name="street_address" placeholder="Address" value="799 montgomery st">
				  	<input class="input city" data-braintree-name="locality" placeholder="City" value="Brooklyn">
				  	<input class="input state" data-braintree-name="reigon" placeholder="State" value="NY">
				  	<input class="input postal" data-braintree-name="postal_code" placeholder="Zip" value="94107">

					<input class="input" name="amount" placeholder="Amount" value="1500.00" >

					<div class="profile__footer">
					  	<input class="btn" type="submit" id="submit" value="Donate">
					</div>
				</div>
			</form>
		</div>
	</div>
    
        <script src="js/index.js"></script>



		<!--form id="checkout" method="post" action="checkout.php">
  			<div id="payment-form"></div>
			<input type='text' name='amount' class="postal-code card-field" placeholder='Amount'/>
  			<input type="submit" value="Donate">
		</form-->

		<!--form id="checkout" action="checkout.php" method="post">
		  	<input data-braintree-name="number" value="4111111111111111">
	  		<input data-braintree-name="cvv" value="100">

		  	<input data-braintree-name="expiration_date" value="10/20">

		  	<input data-braintree-name="cardholder_name" value="John Smith">
		  	<input data-braintree-name="street_address" value="799 montgomery st">
		  	<input data-braintree-name="locality" value="Brooklyn">
		  	<input data-braintree-name="reigon" value="NY">
		  	<input data-braintree-name="postal_code" value="94107">

			<input name="amount" value="1500.00" >
		  	<input type="submit" id="submit" value="Pay">
		</form-->


	</body>
<html>
