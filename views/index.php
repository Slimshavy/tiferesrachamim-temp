<?php
        $candleLighting = 'N/A';
        $maariv = 'N/A';
	$earliestMincha = 'N/A';
        $shabbosEnd = 'N/A';
	$shabbosSunset = 'N/A';
        $parsha = '';

	$curl = curl_init('http://www.hebcal.com/shabbat/?cfg=json&zip=11213&m=50&a=on');
	curl_setopt_array($curl,array(
		CURLOPT_RETURNTRANSFER => 1
		));
	$result = json_decode(curl_exec($curl));
	curl_close($curl);

	if($result)
	{
		$items = $result->items;

		$cl;
		foreach ($items as $item) 
		{
		    if ($item->category == 'parashat') {
		        $parsha = $item->title;
		    }
		    else if ($item->category == 'candles') {
		        $cl = new DateTime($item->date);
			$candleLighting = $cl->format('g:i A');
		    }
		    else if ($item->category == 'havdalah') {
		        $se = new DateTime($item->date);
			$shabbosEnd = $se->format('g:i A');
		    }
		}

		$m = clone $cl;
		$maariv = $m->add( new DateInterval('PT40M'))->format('g:i A');
	}

    	$saturday = strtotime('next saturday');
	$lat=40.650002;
	$lng=-73.949997;
	$zenith = ini_get("date.sunrise_zenith");
    	
	$sunrise = date_sunrise($saturday, SUNFUNCS_RET_TIMESTAMP, $lat, $lng, $zenith, -5);
	$sunset = date_sunset($saturday, SUNFUNCS_RET_TIMESTAMP, $lat, $lng, $zenith, -5);
	$dayLength = $sunset - $sunrise;

	$sunsetDt = new DateTime();
	$sunsetDt->setTimestamp($sunset);
	$shabbosSunset = $sunsetDt->format('g:i A');
    	$shaahZmanitInMinutes = $dayLength / 12 / 60;
    	$em = new DateTime();
	$em->setTimestamp($sunrise);
	$em->add(new DateInterval('PT'.ceil(6.5 * $shaahZmanitInMinutes).'M'));
	$earliestMincha = $em->format('g:i A');
?>
      <h1>Welcome to Tiferes Rachamim</h1>

      <div class="wrap">	 
         <h2 id='zmanim-header'>Zmanim for Shabbos <?php echo $parsha; ?></h2>

         <div class="vals-wrapper">

            <span class='lbl'>Candle Lighting:</span>
            <span class='val candle-lighting'><?php echo $candleLighting; ?></span>
            <div class="clear"></div>

            <span class='lbl'>Maariv:</span>
            <span class='val shul-maariv'><?php echo $maariv; ?></span>
            <div class="clear"></div>

            <span class='lbl'>Shachris:</span>
            <span class='val shul-shachris'>10:30 AM</span>
            <div class="clear"></div>
            <span class='lbl'>Earliest Mincha:</span>
            <span class='val shabbos-earliest-mincha'><?php echo $earliestMincha; ?></span>
            <div class="clear"></div>

            <span class='lbl'>Shabbos Shkia:</span>
            <span class='val shabbos-shkiah'><?php echo $shabbosSunset;?></span>
            <div class="clear"></div>

            <span class='lbl'>Shabbos Ends <span class='plain-text'>(50 minutes after sundown)</span>:</span>
            <span class='val shabbos-ends'><?php echo $shabbosEnd; ?></span>
            <div class="clear"></div>
         </div>
      </div>

      <div class="column-wrap">
         <div class="column">
            <div class="col-head">
               <img src="images/bubble.png" alt=""/>
               <p>Connect</p>
           </div>
            <div class="clear"></div>
            <div class="plain-text">
               <p>Connect to Tiferes Rachamim by joining out WhatsApp group.</p>
	       <div id='whatsapp'>
		 <p> Enter your phone number here to join:</p>
		 <input id='whatsapp-phone'><button id='whatsapp-join' class='btn' onclick='joinWhatsApp()'>Join</button>
	       </div>
            </div> 
         </div
	 ><div class="column">
            <div class="col-head">
               <div class="col-img"><img src="images/location.png" alt=""/></div>
               <div class="col-desc">Location</div>
            </div>
            <div class="clear"></div>
            <div class="plain-text">
               <p>We are located at 534 Crown Street, walk in level. </p>
            </div>
         </div
	 ><div class="column">
            <div class="col-head">
               <div class="col-img"><img src="images/manicon.png" alt=""/></div>
               <div class="col-desc">About</div>
            </div>
            <div class="clear"></div>
            <div class="plain-text">
               <p>Tiferes Rachamim is about bringing jews together. All are accepted and included.</p>
            </div>
         </div>
      </div>
