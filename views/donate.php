<?php
	require_once('include/braintree.php');
?>	 
	<div class="wrap">
	    <h1>Donate to Tiferes Rachamim</h1>
            <div class="clear"></div>

            <form id="checkout" action="/checkout" method="post" class="profile__form">
               <div class="profile__fields">
  	  	  <input class="input card-number" data-braintree-name="number" placeholder="Credit Card Number" maxLength="19" 							onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="4111111111111111" required>

  	          <input class="input cvv" data-braintree-name="cvv" placeholder="Security Code" value="100" required>
	  	  <input class="input expiration" data-braintree-name="expiration_date" placeholder="Expiration (mm/yy)" value="10/20" required>

	  	  <input class="input " data-braintree-name="cardholder_name" placeholder="Cardholder Name" value="John Smith" required>
	  	  <input class="input" data-braintree-name="street_address" placeholder="Address" value="799 montgomery st" required>
	  	  <input class="input city" data-braintree-name="locality" placeholder="City" value="Brooklyn" required>
	  	  <input class="input state" data-braintree-name="region" placeholder="State (e.g. NY)" pattern="[a-zA-Z]{2}" required>
	  	  <input class="input postal" data-braintree-name="postal_code" placeholder="Zip" pattern="\d{5}" required>
	  	  <input class="input" name="email" placeholder="Email Address" type="email" required>

		  <input class="input" name="amount" placeholder="Amount" autocomplete="off" required>
		  <div id="errors">

		  </div>
<?php
	echo "<input class='client-token' type='hidden' value='".Braintree_ClientToken::generate()."'>";
?>
		<input name='client-tz' class='client-tz' type='hidden'>
		  <div class="profile__footer">
		     <h3>Please click the Donate button only once</h3> 
            	     <div class="clear"></div>
		     <input class="btn" type="submit" id="submit" value="Donate">
		  </div>
	       </div>
	    </form>
         </div>
