<?php
global $db, $global_config_arr;

////////////////////////////
//// News Kopf erzeugen ////
////////////////////////////

// Basiert auf der news.php des Frogsystem 2.alix5c.
// Aenderungen gegenueber news.php sind mit ///////////// ANPASSUNG ////////////// markiert.

///////////// ANPASSUNG //////////////
// Sicherheitscheck
if (FS2_CUSTOMNEWS != 'ACTIVE')
	die();
///////////// ANPASSUNG //////////////
	

// News Konfiguration lesen
$index = mysql_query("select * from ".$global_config_arr[pref]."news_config", $db);
$config_arr = mysql_fetch_assoc($index);
$time = time();
$config_arr[num_news] = $config_arr[num_news] * 2;

// Headlines erzeugen

///////////// ANPASSUNG //////////////
$index = mysql_query("select * from ".$global_config_arr[pref]."news
                      where news_date <= $time
                      AND news_active = 1
					  AND $news_cat_id_where
                      order by news_date desc
                      limit $config_arr[num_head]", $db);
///////////// ANPASSUNG //////////////
					  
$news_line_tpl = "";
while ($newshead_arr = mysql_fetch_assoc($index))
{
    $newshead_arr['news_date'] = date_loc ( $global_config_arr['datetime'] , $newshead_arr['news_date'] );
    if ( strlen ( $newshead_arr['news_title'] ) > $config_arr['news_headline_lenght'] && $config_arr['news_headline_lenght'] >=0 ) {
        $newshead_arr['news_title'] = substr ( $newshead_arr['news_title'], 0, $config_arr['news_headline_lenght'] ) . $config_arr['news_headline_ext'];
    }
    
    // Get Template
    $template = new template();
    $template->setFile("0_news.tpl");
    $template->load("APPLET_LINE");

    $template->tag("title", stripslashes ( $newshead_arr['news_title'] ) );
    $template->tag("date", $newshead_arr['news_date'] );
    $template->tag("url", "comments--id-".$newshead_arr['news_id'].".html" );
    $template->tag("news_id", $newshead_arr['news_id'] );

    $template = $template->display ();
    $news_line_tpl .= $template;
}
unset($newshead_arr);

// Neuste Downloads erzeugen
///////////// ANPASSUNG //////////////
$index = mysql_query("select dl_name, dl_id, dl_date
                      from ".$global_config_arr[pref]."dl
                      where dl_open = 1
					  and $dl_cat_id_where
                      order by dl_date desc
                      limit $config_arr[num_head]", $db);
///////////// ANPASSUNG //////////////					  
$downloads_tpl = "";
while ($dlhead_arr = mysql_fetch_assoc($index))
{
    $dlhead_arr['dl_date'] = date_loc ( $global_config_arr['datetime'] , $dlhead_arr['dl_date'] );
    if ( strlen ( $dlhead_arr['dl_name'] ) > $config_arr['news_headline_lenght'] ) {
        $dlhead_arr['dl_name'] = substr ( $dlhead_arr['dl_name'], 0, $config_arr['news_headline_lenght'] ) . $config_arr['news_headline_ext'];
    }

    // Get Template
    $template = new template();
    $template->setFile("0_downloads.tpl");
    $template->load("APPLET_LINE");

    $template->tag("title", stripslashes ( $dlhead_arr['dl_name'] ) );
    $template->tag("date", $dlhead_arr['dl_date'] );
    $template->tag("url", "dlfile--id-".$dlhead_arr['dl_id'].".html" );
    $template->tag("download_id", $dlhead_arr['dl_id'] );

    $template = $template->display ();
    $downloads_tpl .= $template;
}
unset($dlhead_arr);

// Get Headline Template
$template = new template();
$template->setFile("0_news.tpl");
$template->load("APPLET_BODY");

$template->tag("news_lines", $news_line_tpl );
$template->tag("download_lines", $downloads_tpl );

$template = $template->display ();
$headline_template = $template;

////////////////////////////
////// News ausgeben ///////
////////////////////////////

///////////// ANPASSUNG //////////////
$index = mysql_query("select * from ".$global_config_arr[pref]."news
                      where news_date <= $time
                      AND news_active = 1
					  AND $news_cat_id_where
                      order by news_date desc
                      limit $config_arr[num_news]", $db);
///////////// ANPASSUNG //////////////

while ($news_arr = mysql_fetch_assoc($index))
{
	$newsbit = display_news($news_arr, $config_arr[html_code], $config_arr[fs_code], $config_arr[para_handling]);
	
	if ($customnewskeyword != "")
		$newsbit = preg_replace("/([^\(])$customnewskeyword/iS", "$1<strong>$customnewskeyword</strong>", $newsbit);
	
    $news_template .= $newsbit;
}
unset($news_arr);

// Get Template
$template = new template();
$template->setFile("0_news.tpl");
$template->load("BODY");

$template->tag("news", $news_template );
$template->tag("headlines", $headline_template );

///////////// ANPASSUNG //////////////
$template->tag("customnewsheader", ' --> [%customnewsheader_' . $customnewsuffix . '%] <!-- ' );
$template->tag("customnewsintro", ' --> [%customnewsintro_' . $customnewsuffix . '%] <!-- ' );
///////////// ANPASSUNG //////////////

$template = $template->display ();

$global_config_arr['dyn_title_page'] = $customnewstitle;
$global_config_arr['dyn_description_page'] = $customnewsdescription;
?>
