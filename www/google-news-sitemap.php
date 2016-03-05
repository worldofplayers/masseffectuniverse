<?php
/* Einstellungen */

// Dieser Name muss genau mit dem Namen übereinstimmen, der in Ihren Artikeln auf news.google.com angezeigt wird. 
// Nachstehende Klammern werden jedoch nicht eingefügt. 
// Wenn in Google News zum Beispiel der Name "Beispielzeitung (Abo)" angezeigt wird, müssen Sie den Namen "Beispielzeitung" verwenden.

// Falls dieses Feld leer bleibt, wird der voreingestellte Seitentitel verwendet
$sitemap['name'] = 'Mass Effect - Universe';

// Maximales Alter der Artikel, die einbezogen werden sollen (in Tagen)
$sitemap['days'] = 4;

/* Einstellungen Ende */


header("Content-type: application/xml");

set_include_path ('.');
define (FS2_ROOT_PATH, "/", TRUE);

require(FS2_ROOT_PATH . "login.inc.php");

if($db) {
	include(FS2_ROOT_PATH . "includes/functions.php");

	if($global_config_arr['virtualhost'] == "") {
		$global_config_arr['virtualhost'] = "http://example.com/";
	}

	$index = mysql_query("SELECT * FROM ".$global_config_arr['pref']."news_config", $db);
	$news_config_arr = mysql_fetch_assoc($index);
    
    $sitemap['name'] = (trim($sitemap['name']) == '') ? utf8_encode(htmlspecialchars($global_config_arr['title'])) : $sitemap['name'];
    $sitemap['days'] = (int) $sitemap['days'];
    
    $index = mysql_query('SELECT news_id, news_text, news_title, news_date
									  FROM 
                                        '.$global_config_arr['pref'].'news
									  WHERE
                                        news_active = 1
                                      AND
                                        news_date > '.(time()-60*60*24*$sitemap['days']).'
									  ORDER BY
                                        news_date DESC', $db);
										
	if (mysql_num_rows($index) == 0)
		$index = mysql_query('SELECT news_id, news_text, news_title, news_date
									  FROM 
                                        '.$global_config_arr['pref'].'news
									  WHERE
                                        news_active = 1                                     
									  ORDER BY
                                        news_date DESC
									  LIMIT 1', $db);
    
	echo'<?xml version="1.0" encoding="utf-8"?>
    <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:news="http://www.google.com/schemas/sitemap-news/0.9">';
        while ($news_arr = mysql_fetch_assoc($index)) {
            echo '
            <url>
                <loc>'.utf8_encode($global_config_arr['virtualhost'].'comments--id-'.$news_arr['news_id']).'.html</loc>
                <news:news>
                    <news:publication>
                        <news:name>'.$sitemap['name'].'</news:name>
                        <news:language>de</news:language>
                    </news:publication>
                    <news:publication_date>'.utf8_encode(date("Y-m-d",$news_arr['news_date'])).'</news:publication_date>
                    <news:title>'.utf8_encode(killhtml($news_arr['news_title'])).'</news:title>
                </news:news>
            </url>';
        }
    echo'</urlset>';

	mysql_close($db);

} else {
	// Keine Verbindung -> leere Sitemap
	echo'<?xml version="1.0" encoding="utf-8"?>
    <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:news="http://www.google.com/schemas/sitemap-news/0.9">

    </urlset>';
}

?>