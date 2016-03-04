<?php
$results = array();
$results = $_POST;
if(isset($_COOKIE['meu_poll']))
    $cookie = $_COOKIE['meu_poll'];

foreach ($results as $key => &$value) {
    $value = htmlspecialchars($value);
}
$out = <<<DOC
<style type="text/css">
    #poll_answer{font-size:110%;text-align:center;width:500px;height:auto;background-color:white;color:black;padding:10px;}
    .bold{font-size:120%;font-weight:bold;}
	.congrat{color:red; font-size: 108%; font-weight: bold;}
</style>
DOC;
$out .= "<div id=\"poll_answer\">";


$lang = $results['lang'];
if($lang == "Deutsch"){
    $error_string = "<span class=\"bold\">Entschuldigung, aber du hast bereits an der Umfrage teilgenommen. Vielen Dank dafür!</span><br>Wenn du die Umfrage weiter unterstützen möchtest, so erzähle doch
                     bitte deinen Freunden davon! Wir würden uns sehr freuen :)<br>";
    $ok_string = "<span class=\"bold\">Vielen Dank für deine Stimme!</span><br>Wenn du die Umfrage weiter unterstützen möchtest, so erzähle doch bitte deinen Freunden davon! Wir würden uns sehr freuen :)<br>";
    $number_string = "Du warst Nummer ";
    $meu_social = "<br><span style=\"clear:both;\">Erste Ergebnisse der Umfrage werden nach und nach veröffentlicht.<br>Finde uns bei Facebook und Twitter und bleibe auf dem Laufenden!</span>";
	$win_text = "<br><div style=\"background-color: #E6E6E6; padding: 3px;\"><span class=\"congrat\">Herzlichen Glückwunsch!</span><br>Du warst Teilnehmer mit einer besonderen Nummer und hast daher einen Preis gewonnen! Als Dankeschön für die Teilnahme an unserer Umfrage darfst du dich auf den DLC 'From Ashes' für Mass Effect 3 freuen. Du kannst wählen, ob du diesen für die Xbox 360 oder die Playstation 3 haben möchtest. Für den PC haben wir leider keinen.<br><br>Wenn deinen Gewinn einlösen möchtest, schicke bitte eine Email unter Angabe deines Plattform-Wunsches und der untenstehenden Geheimnummer an: noni@masseffect-universe.de<br><br>Bitte beachte, dass Emails ohne Geheimnummer nicht berücksichtigt werden können.<br>Deine Nummer lautet:";
}
else if ($lang == "English"){
    $error_string = "<span class=\"bold\">Sorry, but you have already participated in the survey. Thank you for this!</span><br>If you wish to support the survey further, please tell it your friends! 
                     We would be delighted :)<br>";
    $ok_string = "<span class=\"bold\">Thank you for your vote!</span><br>If you wish to support the survey further, please tell it your friends! We would be delighted :)<br>";
    $number_string = "You were number ";
    $meu_social = "<br><span style=\"clear:both;\">First results of the survey will be published gradually.<br>Find us on Facebook and Twitter and stay up to date!</span>";
	$win_text = "<br><div style=\"background-color: #E6E6E6; padding: 3px;\"><span class=\"congrat\">Congratulations!</span><br>You were participants with a special number, and therefore have won a prize! As a thank you for participating in our survey, you get the DLC 'From Ashes' for Mass Effect 3. You can choose whether you want to have this for the Xbox 360 or Playstation 3. For the PC we have unfortunately none.<br><br>If you would like to redeem your winning, please send me an email stating your favored platform and the secret number below: noni@masseffect-universe.de<br><br>Please note that no emails without a secret code can be considered.<br>Your number is:";
}
else{
    echo "An error occurred! Please try again!<br>If the problem remains please write an email to noni[at]masseffect-universe.de";
    exit();
}
    
$fb_init = <<<DOC
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/de_DE/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
DOC;
$fb_string = <<<DOC
<div class="fb-like" data-send="true" data-layout="button_count" data-width="450" data-show-faces="true" data-font="arial"></div>
DOC;
$tw_string = <<<DOC
<a href="https://twitter.com/share" class="twitter-share-button" data-via="MassEffectUni" data-hashtags="MassEffect3">Tweet</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
DOC;
$social_string = $fb_init . "<br><table align=\"center\"><tr><td>" . $fb_string . "</td></tr></table><table align=\"center\"><tr><td>" . $tw_string . "</td></tr></table>";

$end = 1337291999;
$timestamp = time();

if($timestamp > $end){
    $out .= "<span class='bold'>The Survey is now closed!<br>Results coming soon :)<br>---<br>Die Umfrage ist nun geschlossen.<br>Ergebnisse folgen in Kürze :)</span>";
}
else{
	if(!isset($cookie)){
		//Zeit und Cookie
		$time_now = time();
		$wait = $time_now + 3600*24*7;
		setcookie("meu_poll", "voted", $wait);

		//IP
		$ip = $_SERVER['REMOTE_ADDR'];

		//DB-Connect
        mysql_connect("localhost", "masseffect", "4IetGE2TxO_b1MU") or die(mysql_error());
        mysql_select_db("db_masseffect") or die(mysql_error());
		
		$sperre = $time_now - 120; 
		
		$ip_delete = mysql_query("DELETE FROM ipban WHERE time < '$sperre'") or die(mysql_error());
		
		$check = mysql_query("SELECT ip FROM ipban WHERE ip='$ip'") or die(mysql_error());
		if(@!mysql_fetch_array($check)){
			
			$ip_write = mysql_query("INSERT INTO poll (lang, Q1, Q2, Q3, Q4, Q5, Q6, Q7, Q8, Q9_1, Q9_2, Q10, Q11, Q12, Q13, Q14, Q15, Q16, Q17, Q18, Q19, Q20, Q21, Q22, Q23, Q24, Q25, Q26, Q27, Q28, Q29, Q30, Q31, Q32, Q33, Q34, Q35, Q36, Q37, Q38) VALUES ('$results[lang]', '$results[q1]', '$results[q2]', '$results[q3]', '$results[q4]', '$results[q5]', '$results[q6]', '$results[q7]', '$results[q8]', '$results[q9_1]', '$results[q9_2]', '$results[q10]', '$results[q11]', '$results[q12]', '$results[q13]', '$results[q14]', '$results[q15]', '$results[q16]', '$results[q17]', '$results[q18]', '$results[q19]', '$results[q20]', '$results[q21]', '$results[q22]', '$results[q23]', '$results[q24]', '$results[q25]', '$results[q26]', '$results[q27]', '$results[q28]', '$results[q29]', '$results[q30]', '$results[q31]', '$results[q32]', '$results[q33]', '$results[q34]', '$results[q35]', '$results[q36]', '$results[q37]', '$results[q38]')");
			$number2 = mysql_insert_id();
			$Q_write = mysql_query("INSERT INTO ipban (ip, time) VALUES ('$ip', '$time_now')");
			
			if($ip_write AND $Q_write){
				//$get_number = mysql_query("SELECT ID FROM poll ORDER by ID DESC LIMIT 1");
				//$number = mysql_fetch_array($get_number);
				
					$out .= $ok_string;
					//$out .= "Alte Nummer " . $number_string . $number['ID'] . ".<br>";
					$out .= $number_string . $number2 . ".<br>";

					switch($number2){
							case 18000:
									$win_number = 356914;
									break;
							case 19000:
									$win_number = 728536;
									break;
							case 20000:
									$win_number = 791452;
									break;
					}

					if(isset($win_number)){
							$out .= $win_text . "<span style=\"color:red;\">" . $win_number . "</span></div>";
					}
				
				$out .= $social_string;
				$out .= $meu_social;
			}
		}
		else{
			$out .= $error_string;
			$out .= $social_string;
			$out .= $meu_social;
			//$out .= "<br>IP<br>";

		}
	}
	else{
		$out .= $error_string;
		$out .= $social_string;
		$out .= $meu_social;
		//$out .= "<br>Cookie<br>";
	}
}
$out .= "</div>";
echo $out;
?>
