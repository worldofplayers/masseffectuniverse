<?php
global $db, $global_config_arr;
header( "Content-Type: text/html; charset=UTF-8");

$forename = htmlspecialchars($_POST['forename']);
$surname = htmlspecialchars($_POST['surname']);
$email = htmlspecialchars($_POST['email']);

if(isset($_COOKIE["MEU_OctoberContest"])) {
	$cookie = htmlspecialchars($_COOKIE["MEU_OctoberContest"]);
}
else {
	$cookie = "notset";
}

$feedback = "";
//1387839601 -> 07.10. 00:00:01
//1387925999 -> 13.10. 23:59:59
$currentTime = time();

if($currentTime >= 1387839601 AND $currentTime <= 1387925999) {

	if($cookie != "participant") {

		if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$ip = $_SERVER['REMOTE_ADDR'];
			
			$ua = $_SERVER['HTTP_USER_AGENT'];
			$user = "UserInfo: " . $ua;
			
			$insert = mysql_query("INSERT INTO october_contest (ID, Datum, IP, Vorname, Nachname, Email, User)
								   VALUES (NULL, NULL, '" . $ip . "',
										   '" . mysql_real_escape_string($forename) . "',
										   '" . mysql_real_escape_string($surname) . "',
										   '" . mysql_real_escape_string($email) . "',
										   '" . mysql_real_escape_string($user) . "')", $db);
			$number = mysql_insert_id();
			
			if($insert){
				//Erfolgreich
				$feedback .= "Vielen Dank, dass du teilgenommen hast!<br>Du bist nun im Lostopf.";
				setcookie("MEU_OctoberContest", "participant", time() + 86400);
			}	
			else {
				//DB-Problem
				$feedback .= "Es gibt ein Problem mit der Datenbank";
			}
			
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
	//Zu fr�h oder sp�t
	$feedback  .= "Das Gewinnspiel ist leider bereits beendet!";
}

echo $feedback;
?>
