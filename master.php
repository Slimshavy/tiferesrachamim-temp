<?php
	ini_set('display_errors','Off');
	$config = require_once("config/main.php");
	if($config['devlopment'] == true)
		ini_set('display_errors','On');

	require_once('helpers/MailerHelper.php');
	require_once("dal/access.php");

	$title = '';
	$route = 'notfound';
	$view = 'views/notfound.php';
	$styles = '';
	$scripts = '';

	if(isset($_GET['route']))
	{
		$r = 'controllers/'.$_GET['route'].'Controller.php';	
		if(file_exists($r ))
		{

			$route = $r;
			$controller = require_once($route);
			
			$view = 'views/'.$controller['view'].'.php';

			if(isset($controller['type']) && $controller['type'] == 'json')
			{
				header('Content-Type: application/json');
				require_once($view);
				exit();
			}
	
			$title = $controller['title'];
			
			
			if(isset($controller['styles'] ))
				foreach($controller['styles'] as $style)
					$styles .= "   <link rel='stylesheet' href='/styles/$style.css' type='text/css' media='all' /> \n";

			if(isset($controller['scripts'] ))
				foreach($controller['scripts'] as $script)
					$scripts .= "   <script type='text/javascript' src='/scripts/$script.js'></script> \n";
		}
	}
	ob_start();
?>
<!DOCTYPE HTML>
<html>
<head>
   <title> <?php echo $title; ?> - Tiferes Rachamim</title>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <link rel="shortcut icon" href='images/favicon.ico' type='imagex-icon' />
   <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

   <link rel="stylesheet" href="/styles/style.css" type="text/css" media="all" />
   <?php echo $styles; ?>

   <?php echo $scripts; ?>
</head>

<body>
   <div class="content">
      <header>
	 <div class="inner">
            <div class="logo"><a href="/">Tiferes Rachamim</a> </div>
	    <div class="donate-link"><a href="/donate"> Donate </a></div>
	 <div class="clear"></div>
	
      </header>
      <main>
<?php
	require_once($view);
	ob_end_flush();
?>
      </main>
      <div class="clear"></div>
      <div class="push"></div>
   </div>

   <footer>
      ©2016 Tiferes Rachamim. All rights reserved | Created by Shavy Yarmush
   </footer>

</body>
</html>
