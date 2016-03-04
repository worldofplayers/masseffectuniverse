<?php
header( "Content-Type: text/html; charset=UTF-8");

$forename = htmlspecialchars($_POST['forename']);
$surname = htmlspecialchars($_POST['surname']);
$email = htmlspecialchars($_POST['email']);

if(isset($_COOKIE["MEU_ParagonLost"])) {
	$cookie = htmlspecialchars($_COOKIE["MEU_ParagonLost"]);
}
else {
	$cookie = "notset";
}

$feedback = "";
//1363777200 -> 20.03. 12:00:00
//1364425199 -> 27.03. 23:59:59
$currentTime = time();

if($currentTime >= 1363777200 AND $currentTime <= 1364425199) {

	if($cookie != "participant") {

		if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$ip = $_SERVER['REMOTE_ADDR'];

			$ua = $_SERVER['HTTP_USER_AGENT'];
			$browser = get_browser(null, true);
			$user = md5("1UserInfo_" . $ua) . "2UserInfo_" . serialize($browser);

			$link = mysql_connect("localhost", "masseffect", "4IetGE2TxO_b1MU") or die ("Keine Verbindung zur Datenbank");
			$select = mysql_select_db("db_masseffect") or die ("Die Datenbank existiert nicht.");

			$insert = mysql_query("INSERT INTO paragonlostparticipants (ID, Datum, IP, Vorname, Nachname, Email, User)
								   VALUES (NULL, NULL, '" . $ip . "',
										   '" . mysql_real_escape_string($forename) . "',
										   '" . mysql_real_escape_string($surname) . "',
										   '" . mysql_real_escape_string($email) . "',
										   '" . mysql_real_escape_string($user) . "')");
			$number = mysql_insert_id();
			
			if($insert){
				//Erfolgreich
				$feedback .= "Vielen Dank, dass du teilgenommen hast!<br>Du bist nun im Lostopf.";
				setcookie("MEU_ParagonLost", "participant", time() + 604800);
			}	
			else {
				//DB-Problem
				$feedback .= "Es gibt ein Problem mit der Datenbank";
			}

			mysql_close($link);
			
		}
		else {
			//Email nicht korrekt
			$feedback  .= "Deine Email-Adresse scheint nicht korrekt zu sein...";
		}
	}
	else {
		//Bereits teilgenommen
		$feedback .= "Du hast bereits teilgenommen!";
	}
}
else {
	//Zu früh oder spät
	$feedback  .= "Das Gewinnspiel ist leider bereits beendet!";
}

echo $feedback;
?>
