<?php
$url = substr($_GET['go'], -3);
$header = array();
$nummer = 1;


	if ($url == "me3") {
		while ($nummer <= 10) {
			$header[$nummer] = "styles/lightfrog/header/header_me3_{$nummer}.jpg";
			$nummer++;
		}
	}
	elseif ($url == "me2") {
		while ($nummer <= 10) {
			$header[$nummer] = "styles/lightfrog/header/header_me2_{$nummer}.jpg";
			$nummer++;
		}
	}
	elseif ($url == "me1") {	
		while ($nummer <= 10) {
			$header[$nummer] = "styles/lightfrog/header/header_me1_{$nummer}.jpg";
			$nummer++;
		}
	}
	elseif ($url == "uni") {
		while ($nummer <= 10) {
			$header[$nummer] = "styles/lightfrog/header/header_me4_{$nummer}.jpg";
			$nummer++;
		}
	}
	else {
	$header[1] = "styles/lightfrog/header/header.jpg";
	$header[2] = "styles/lightfrog/header/header.jpg";
	}

$max = count($header);
$zufall = rand(1, $max);
$template = "<img src=\"$header[$zufall]\" alt=\"Mass Effect-Universe\" width=\"1012\" height=\"150\">";
?>