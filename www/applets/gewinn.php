<?php
$forename = htmlspecialchars($_POST['forename']);
$surname = htmlspecialchars($_POST['surname']);
$email = htmlspecialchars($_POST['email']);
$key = htmlspecialchars($_POST['key']);

$answers = array();

for($i = 1; $i <= 10; $i++){
    
    $answers[$i] = htmlspecialchars($_POST["question{$i}"]);
}
    
if(filter_var($email, FILTER_VALIDATE_EMAIL) == true) {
    $mailheader  = "From: Mass Effect - Universe<noreply@" .$_SERVER['SERVER_NAME']. ">\r\n";
    //$mailheader .= "Reply-To: " .$_SESSION["name"]. "<" .$_SESSION["email"]. ">\r\n";
    $mailheader .= "Return-Path: noreply@" .$_SERVER['SERVER_NAME']. "\r\n";
    $mailheader .= "MIME-Version: 1.0\r\n";
    $mailheader .= "Content-Type: text/html; charset=UTF-8\r\n";
    $mailheader .= "Content-Transfer-Encoding: 7bit\r\n";
    $mailheader .= "Message-ID: <" .time(). " noreply@" .$_SERVER['SERVER_NAME']. ">\r\n";
    $mailheader .= "X-Mailer: PHP v" .phpversion(). "\r\n\r\n";

    $text = "Teilnehmer: " . $forename . " " . $surname . "<br />Email-Adresse: " . $email . "<br />Lösungswort " . $key;
    $text .= "Antworten auf die Fragen: <br />";
    for($i = 1; $i <= 10; $i++){
        $text .= "<br />" . $answers[$i];
    }
    
    $text = preg_replace( "/(content-type:|bcc:|cc:|to:|from:)/im", "", $text);
    mail("noni@masseffect-universe.de", "Gewinnspiel - Mass Effect", $text, $mailheader);
    
    echo "<p style=\"padding: 15px;\">Danke für die Teilnahme!</p>";
} 
else{
    echo "<p style=\"padding: 15px;\">Da lief was schief, bitte noch einmal abschicken<br>Deine Daten wurden im Formular zwischengespeichert, sodass du nicht alles nochmal eingeben musst.</p>";
}
?>
