<?php
global $db, $global_config_arr;

$url = $_GET["go"];

$index = mysql_query ( "
                        SELECT `inhalt`
                        FROM `inhaltsverzeichnis`
						WHERE `article_url`='$url'
", $db);

$row = mysql_fetch_array($index);
$inhalt = $row['inhalt'];

if(!empty($inhalt)){
$inhalt = unserialize(gzuncompress(base64_decode($inhalt)));
$laenge = count($inhalt);
}

if(!empty($inhalt)){
	$template = "<span id=\"inhaltsverzeichnis\"><div class=\"inhaltsverzeichnis_pop shine\"><p style=\"font-weight: bold;\">Inhaltsverzeichnis:</p><ul>";
        for($i = 0; $i < $laenge; $i++){
            $template .= "$inhalt[$i]";
        }
        $template .= "</ul></div></span>";
}
else {
	$template = "";
}
?>
