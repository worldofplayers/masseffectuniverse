<?php
global $db, $global_config_arr;

$votes_total = 0;
$anzahl1 = mysql_query("
                        SELECT SUM(total_ratings)
                        FROM fs2_articles
", $db);

$row = mysql_fetch_row($anzahl1); 		
$votes_total += $row[0]; 

$anzahl2 = mysql_query("
                        SELECT SUM(total_ratings)
                        FROM fs2_news
", $db);

$row = mysql_fetch_row($anzahl2); 		
$votes_total += $row[0]; 

$template = $votes_total;
?>
