<?php
	require_once('include/braintree.php');
?>	 
  <div class="wrap">

    <h1>Donate to Tiferes Rachamim</h1>
    <div class="clear"></div>

    <form id="checkout" action="/checkout" method="post" class="profile__form">
      <div class="profile__fields">

        <div class="field" id="card-number">
          <input class="input" data-braintree-name="number" placeholder="Credit Card Number" required>
          <div class="error-msg"></div>
        </div>

        <div class="field" id="cvv">
          <input class="input" data-braintree-name="cvv" placeholder="Security Code" required>
          <div class="error-msg"></div>
        </div>

        <div class="field" id="expiration">
          <input class="input" data-braintree-name="expiration_date" placeholder="Expiration (mm/yy)" required>
          <div class="error-msg"></div>
        </div>

        <div class="field" id="card-name">
          <input class="input" data-braintree-name="cardholder_name" placeholder="Cardholder Name" required>
          <div class="error-msg"></div>
        </div>

        <div class="field" id="address">
          <input class="input" data-braintree-name="street_address" placeholder="Address" required>
          <div class="error-msg"></div>
        </div>

        <div class="field" id="city">
          <input class="input" data-braintree-name="locality" placeholder="City" required>
          <div class="error-msg"></div>
        </div>

        <div class="field" id="state">
          <input class="input" data-braintree-name="region" placeholder="State (e.g. NY)" required>
          <div class="error-msg"></div>
        </div>

        <div class="field" id="postal">
          <input class="input" data-braintree-name="postal_code" placeholder="Zip" required>
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
<?php
	echo "<input class='client-token' type='hidden' value='".Braintree_ClientToken::generate()."'>";
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
