<?php
	ini_set('display_errors','On');

	$title = '';
	$route = 'notfound';
	$view = 'notfound.php';
	$styles = '';
	$scripts = '';

	if(isset($_GET['route']))
	{
		$r = 'controllers/'.$_GET['route'].'Controller.php';	
		if(file_exists($r ))
		{
			$route = $r;
			$controller = require_once($route);
			$title = $controller['title'];
			$view = 'views/'.$controller['view'].'.php';
			
			if(isset($controller['styles'] ))
				foreach($controller['styles'] as $style)
					$styles .= "   <link rel='stylesheet' href='/styles/$style.css' type='text/css' media='all' /> \n";

			if(isset($controller['scripts'] ))
				foreach($controller['scripts'] as $script)
					$scripts .= "   <script type='text/javascript' src='/scripts/$script.js'></script> \n";
		}
	}
?>
<!DOCTYPE HTML>
<html>
<head>
   <title>Tiferes Rachamim <?php echo $title ?></title>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <link rel="shortcut icon" href='images/favicon.ico' type='imagex-icon' />
   <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

   <link rel="stylesheet" href="/styles/style.css" type="text/css" media="all" />
   <?php echo $styles; ?>

   <script type="text/javascript" src="/scripts/jquery.js"></script>
   <?php echo $scripts; ?>
</head>

<body>
   <div class="content">
      <div class="header">
	 <div class="menu-wrap">
            <div class="logo">
	       <a href="/">Tiferes Rachamim</a> 
	    </div>
	 <div class="clear"></div>
      </div>
   </div>
      
<?php
	require_once($view);
?>

	<div class="clear"></div>
	<div class="push"></div>
   </div>
   <div class="footer">
      ©2016 Tiferes Rachamim. All rights reserved | Created by Shavy Yarmush
   </div>

</body>
</html>
