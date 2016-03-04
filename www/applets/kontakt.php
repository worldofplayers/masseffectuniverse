<?php
if(isset($_POST["submit"]) && ($_POST["submit"] == "Abschicken")) {

    if(empty($_POST["name"]) || empty($_POST["email"]) || empty($_POST["nachricht"]))  {
	
		header("Location: ../?go=kontakt&su=kn");
		exit;
	}
	else {
    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $nachricht = htmlspecialchars($_POST["nachricht"]);
    $betreff = htmlspecialchars($_POST["auswahl"]);

	if(!(filter_var($email, FILTER_VALIDATE_EMAIL))) {
        header("Location: ../?go=kontakt&su=we");
		exit;
    }
    
	$mailheader  = "From: Mass Effect - Universe<noreply@" .$_SERVER['SERVER_NAME']. ">\r\n";
    $mailheader .= "Reply-To: " .$_SESSION["name"]. "<" .$_SESSION["email"]. ">\r\n";
    $mailheader .= "Return-Path: noreply@" .$_SERVER['SERVER_NAME']. "\r\n";
    $mailheader .= "MIME-Version: 1.0\r\n";
    $mailheader .= "Content-Type: text/html; charset=UTF-8\r\n";
    $mailheader .= "Content-Transfer-Encoding: 7bit\r\n";
    $mailheader .= "Message-ID: <" .time(). " noreply@" .$_SERVER['SERVER_NAME']. ">\r\n";
    $mailheader .= "X-Mailer: PHP v" .phpversion(). "\r\n\r\n";
	
    $text = "Der Besucher $name (email: $email) sendet folgende Anfrage:<br />$nachricht";
    //mail("c.riewe@masseffect-universe.de", "ME-U-Kontakt: " . $betreff, $text, $mailheader);
    header("Location: ../?go=kontakt&su=su");
	exit;       
}  
}
?>