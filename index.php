<?php
	ini_set('display_errors','On');

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
<!DOCTYPE HTML>
<html>
<head>
    <title>Tiferes Rachamim - Home</title>
<?php
	include("/include/headers.html");
?>
</head>

<body>
<?php
	include("/include/body-head.html");
?>
      <div class="wrap">
         <h1>Welcome to Tiferes Rachamim</h1>
         <div class="clear"></div>
         <h2><a href="/donate"> Donate </a></h2>
         <div class="clear"></div>

         <div class="vals-wrapper">
            <h2 id='zmanim-header'>Zmanim for Shabbos <?php echo $parsha; ?></h2>

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

            <span class='lbl'>Shabbos Ends <span class='small-note'>(50 minutes after sundown)</span>:</span>
            <span class='val shabbos-ends'><?php echo $shabbosEnd; ?></span>
            <div class="clear"></div>
         </div>
      </div>

      <div class="wrap">
         <div class="col span_1_of_3">
            <div class="grid-bot">
               <div class="grid1-l-img"><img src="images/bubble.png" alt=""/></div>
               <div class="grid1-l-desc"><p>Connect</p></div>
               <div class="clear"></div>
               <div class="grid-desc">
                  <p>Come connect with you fellow pairs at our weekly shabbos prayers and kiddush.</p>
               </div>
            </div>
         </div>
         <div class="col span_1_of_3">
            <div class="grid-bot">
               <div class="grid1-l-img"><img src="images/location.png" alt=""/></div>
               <div class="grid1-l-desc"><p>Location</p></div>
               <div class="clear"></div>
               <div class="grid-desc">
                  <p>We are located at 534 Crown Street, walk in level. </p>
               </div>
            </div>
         </div>
         <div class="col span_1_of_3">
            <div class="grid-bot">
               <div class="grid1-l-img"><img src="images/manicon.png" alt=""/></div>
               <div class="grid1-l-desc"><p>About</p></div>
               <div class="clear"></div>
               <div class="grid-desc">
                  <p>Tiferes Rachamim is about bringing jews together. All are accepted and included.</p>
               </div>
            </div>
         </div>
      </div>
<?php
	include("/include/body-foot.html");
?>

</body>
</html>
