<?php

/// EINSTELLUNGEN ///

// SQL-Bedingung zum Filtern der News
// Ueblicherweise wird man in der Klammer alle passenden Newskategorien auffuehren, 
// es sind aber prinzipiell beliebig komplexe SQL-Ausdruecke moeglich.
$news_cat_id_where = 'cat_id = 4';

// SQL-Bedingung zum Filtern der Downloads
// Ueblicherweise wird man in der Klammer alle passenden Downloadkategorien auffuehren, 
// es sind aber prinzipiell beliebig komplexe SQL-Ausdruecke moeglich.
// Es muessen alle Downloadkategorien explizit aufgefuert werden, nicht nur die Oberkategorien.
$dl_cat_id_where = 'cat_id = 10';

// Suffix des customnewsheader_... und customnewsintro_...-Schnipsels
// (werden direkt ober- bzw. unterhalb der Schlagzeilen und Downloads angezeigt
$customnewsuffix = 'masseffect3';

$customnewstitle = 'Mass Effect 3';
$customnewsdescription = 'Hier gibt es alle Infos zum dritten Teil der epischen SciFi-Saga von Bioware - aktuelle News, Hintergründe, Downloads und alles was du sonst wissen musst.';
$customnewskeyword = 'Mass Effect 3';

/// EINSTELLUNGEN ENDE ///

// Sicherheitscheck
define('FS2_CUSTOMNEWS', 'ACTIVE');

require('data/news_custom.php');

?>