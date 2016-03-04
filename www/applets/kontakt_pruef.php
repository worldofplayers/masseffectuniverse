<?php
$erg = $_GET["su"];
if($erg == "su")
	$template = "<br><p class=\"form_feedback shine\"><img src=\"../styles/lightfrog/warnung.gif\" alt=\"\"> Die Email wurde erfolgreich versendet!</p>";
else if($erg == "kn")
	$template = "<br><p class=\"form_feedback shine\"><img src=\"../styles/lightfrog/warnung.gif\" alt=\"\"> Bitte alle Felder ausfuellen!</p>";
else if($erg == "we")
	$template = "<br><p class=\"form_feedback shine\"><img src=\"../styles/lightfrog/warnung.gif\" alt=\"\"> Die Email-Adresse entspricht nicht dem geforderten Format!</p>";
else
	$template = "Bitte unten stehende Felder ausfuellen, um das Formular abzusenden.";
?>