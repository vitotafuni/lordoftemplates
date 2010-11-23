<?php
	header("Content-type: text/css"); 
	/*
	* The dynamic css gives you the possibility to play with css
	* using some server-side calculated variables
	*/
	function getRGB($baseRGB){
      	$baseRGB = round((216*$baseRGB)/255)%216; // only 216 web safe colors
		$RGB = array('00','33','66','99','CC','FF');
    	$R = $RGB[$baseRGB % 6];
		$G = $RGB[round($baseRGB/36)];
      	$B = $RGB[round($baseRGB/6)%6];
      	return '#'.$R.$G.$B;
	}
	
	$ip=explode('.',$_SERVER['REMOTE_ADDR']);
	
	$color = getRGB($ip[3]);

?>

a { color:<?php echo $color; ?>; }
