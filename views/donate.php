<?php
	require_once('helpers/BraintreeHelper.php');
?>
  <div class="wrap" id="noscript-wrap">
    <noscript> 
      <p>This page needs JavaScript enabled. Please enable JavaScript and try again.</p>
    </noscript>
  </div>

  <h1>Donate to Tiferes Rachamim</h1>

  <div class="wrap hidden" id="donate-wrap">

    <form id="checkout" action="/checkout" method="post" class="profile__form">
      <div class="profile__fields">

	<div class="field half" id="firstname">
          <input class="input" placeholder="First Name" name='fname' required>
          <div class="error-msg"></div>
        </div>

        <div class="field half" id="lastname">
          <input class="input" placeholder="Last Name" name='lname' required>
          <div class="error-msg"></div>
        </div>

        <div class="field" id="card-number">
          <input class="input" data-braintree-name="number" name='cardnumber' placeholder="Credit Card Number" required>
          <div class="error-msg"></div>
        </div>

        <div class="field half" id="cvv">
          <input class="input" data-braintree-name="cvv" name='cvc' placeholder="Security Code" required>
          <div class="error-msg"></div>
        </div>

        <div class="field half" id="expiration">
          <input class="input" data-braintree-name="expiration_date" name='cc-exp' placeholder="Expiration (mm/yy)" required>
          <div class="error-msg"></div>
        </div>

        <div class="field" id="card-name">
          <input class="input" data-braintree-name="cardholder_name" name='ccname' placeholder="Cardholder Name" required>
          <div class="error-msg"></div>
        </div>

        <div class="field" id="address">
          <input class="input" data-braintree-name="street_address" name='address' placeholder="Address" required>
          <div class="error-msg"></div>
        </div>

        <div class="field half" id="city">
          <input class="input" data-braintree-name="locality" name='city' placeholder="City" required>
          <div class="error-msg"></div>
        </div>

        <div class="field" id="state">
          <input class="input" data-braintree-name="region" name='state' placeholder="State (e.g. NY)" required>
          <div class="error-msg"></div>
        </div>

        <div class="field" id="postal">
          <input class="input" data-braintree-name="postal_code" name='zip' placeholder="Zip" required>
          <div class="error-msg"></div>
        </div>

        <div class="field" id="email">
          <input class="input" name="email" placeholder="Email Address" required>
          <div class="error-msg"></div>
        </div>

        <div class="field" id="amount">
          <input class="input" name="amount" placeholder="Amount" autocomplete="off" required>
          <div class="error-msg"></div>
        </div>

	<div id='monthly-wrap'>
   	   <p>Would you like this payment to recur on a monthly basis?</p>
	   <div class="radio-wrap">
	     <div class="radio-field float-left"><input type="radio" name="monthly" value="yes"> <label class=radio-label"> Yes </label></div>
  	     <div class="radio-field float-right"><input type="radio" name="monthly" value="no" checked> <label class=radio-label"> No </label></div>
	   </div>
	   <p id='monthly-info'>
 	      By clicking the donate button below, you agree to Tiferes Rachamim charging your card the specified amount on a
	      monthly basis. You may call Laibie at (347) 403-1660 to cancel the recurring charges at any time. On the confirmation screen you will see
	      the recurring charge information; please contact Laibie immediately if the information is incorrect.
	   </p>
	</div>
<?php
	echo "<input class='client-token' type='hidden' value='".BraintreeHelper::getInstance()->generateClientToken()."'>";
?>
	<input name='client-tz' class='client-tz' type='hidden'>

      </div>

      <div class="profile__footer">
        <div class="disclaimer">Please click the Donate button only once</div>

        <div class="clear"></div>
        <input class="btn" type="submit" id="submit" value="Donate">
      </div>
  </form>
</div>
