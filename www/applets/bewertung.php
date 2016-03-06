<?php
global $db, $global_config_arr;

$url = htmlspecialchars($_GET['go']);

$index = mysql_query ( "
                        SELECT `rating`
                        FROM `fs2_articles`
						WHERE `article_url`='$url'
", $db);

$row = mysql_fetch_array($index);

$rating = $row['rating'];
 
 if($rating == 0) {
	
$template = <<<DOC
<div id='bewertung'><span style="position: relative; top: -4px; font-size: 50%;"><a href="?go={$url}#rate">Noch keine Bewertung</a></span></div>
DOC;
 }
 else {
 for($i = 1; $i <= 5; $i++) {
    if($rating == $i) {
        $sterne = $i;
        }
 }
 $template = <<<DOC
<div id='bewertung'><img src='styles/lightfrog/{$sterne}stars.png' alt='' /></div>
DOC;
}
?>
