<?php
setlocale (LC_ALL, 'de_DE@euro', 'de_DE', 'de', 'ge');

$zaehler = 0;
$index = mysql_query("select * from ".$global_config_arr[pref]."news_config", $db);
$config_arr = mysql_fetch_assoc($index);
$limit = $config_arr[num_news];

$timestamp = time();
echo $timestamp;
echo $limit;
?>