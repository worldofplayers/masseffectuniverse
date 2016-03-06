<?php
global $db, $global_config_arr;
header( "Content-Type: text/html; charset=UTF-8");

$forename = htmlspecialchars($_POST['forename']);
$surname = htmlspecialchars($_POST['surname']);
$email = htmlspecialchars($_POST['email']);
$platform = htmlspecialchars($_POST['platform']);

$feedback = "";

//1356332400 -> 24.12. 08:00:00
//1356389999 -> 24.12. 23:59:59
$currentTime = time();

if($currentTime >= 1356332400 AND $currentTime <= 1356389999) {
	if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$ip = $_SERVER['REMOTE_ADDR'];
		
		$checkIP = mysql_query("SELECT IP FROM xmascontest WHERE ip='" . $ip . "'", $db) or die("Die Tabelle existiert nicht");
		
		if(@!mysql_fetch_array($checkIP)) {
			$insert = mysql_query("INSERT INTO xmascontest (ID, Datum, IP, Vorname, Nachname, Email, Plattform)
								   VALUES (NULL, NULL, '" . $ip . "',
										   '" . mysql_real_escape_string($forename) . "',
										   '" . mysql_real_escape_string($surname) . "',
										   '" . mysql_real_escape_string($email) . "',
										   '" . mysql_real_escape_string($platform) . "')", $db);
			$number = mysql_insert_id();
			if($insert){
				$feedback .= "Vielen Dank, dass du teilgenommen hast!<br>Du bist nun im Lostopf.";
			}	
			else {
				//DB-Problem
				$feedback .= "Es gibt ein Problem mit der Datenbank";
			}
		}
		else {
			//IP bereits in DB
			$feedback .= "Du hast bereits teilgenommen!";
		}
		
	}
	else {
		//Email nicht korrekt
		$feedback  .= "Deine Email-Adresse scheint nicht korrekt zu sein...";
	}
}
else {
	//Zu fr�h oder sp�t
	$feedback  .= "Das Gewinnspiel ist leider bereits beendet.";
}

echo $feedback;
?>
