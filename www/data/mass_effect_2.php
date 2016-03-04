<?php

/// EINSTELLUNGEN ///

// SQL-Bedingung zum Filtern der News
// Ueblicherweise wird man in der Klammer alle passenden Newskategorien auffuehren, 
// es sind aber prinzipiell beliebig komplexe SQL-Ausdruecke moeglich.
$news_cat_id_where = 'cat_id = 3';

// SQL-Bedingung zum Filtern der Downloads
// Ueblicherweise wird man in der Klammer alle passenden Downloadkategorien auffuehren, 
// es sind aber prinzipiell beliebig komplexe SQL-Ausdruecke moeglich.
// Es muessen alle Downloadkategorien explizit aufgefuert werden, nicht nur die Oberkategorien.
$dl_cat_id_where = 'cat_id in (9,12)';

// Suffix des customnewsheader_... und customnewsintro_...-Schnipsels
// (werden direkt ober- bzw. unterhalb der Schlagzeilen und Downloads angezeigt
$customnewsuffix = 'masseffect2';

$customnewstitle = 'Mass Effect 2';
$customnewsdescription = 'Hier gibt es alle Infos zum zweiten Teil der epischen SciFi-Saga von Bioware - aktuelle News, Hintergr�nde, Downloads und alles was du sonst wissen musst.';
$customnewskeyword = 'Mass Effect 2';

/// EINSTELLUNGEN ENDE ///

// Sicherheitscheck
define('FS2_CUSTOMNEWS', 'ACTIVE');

require('data/news_custom.php');

?>