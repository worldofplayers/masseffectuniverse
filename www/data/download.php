<?php
if (!isset($_GET[catid]))
{
   $show = false;
   $_GET[catid] = 0;
}
else
{
    $show = true;
    if ($_GET[catid] == "all") {
        $_GET[catid] = 0;
    }
    settype($_GET[catid], 'integer');
}

if (isset($_GET[keyword]) AND $_GET[keyword] != "")
{
    $_GET[keyword] = savesql($_GET[keyword]);
    if ($_GET[catid] != 0) {
        $query = "WHERE (dl_text LIKE '%$_GET[keyword]%' OR dl_name LIKE '%$_GET[keyword]%') AND cat_id = $_GET[catid] AND";
    } else {
        $query = "WHERE dl_text LIKE '%$_GET[keyword]%' OR dl_name LIKE '%$_GET[keyword]%' AND";
    }
    $page_titel = "Suchergebnisse";
}
else
{
    $query = "WHERE cat_id = $_GET[catid] AND";
    if ($_GET[catid] == 0)
    {
       $query = "WHERE";
    }
}


/////////////////////////////
//// Navigation erzeugen ////
/////////////////////////////

$valid_ids = array();
get_dl_categories (&$valid_ids, -1);

foreach ($valid_ids as $cat)
{
    if ($cat[cat_id] == $_GET[catid])
    {
        $icon = "dl_ordner_offen.gif";
    }
    else
    {
        $icon = "dl_ordner.gif";
    }
    $index = mysql_query("select dl_navigation from ".$global_config_arr[pref]."template where id = '$global_config_arr[design]'", $db);
    $template = stripslashes(mysql_result($index, 0, "dl_navigation"));
    $template = str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", $cat[ebene]) . $template;
    $template = str_replace("{kategorie_url}", "?go=download&amp;catid=".$cat[cat_id], $template);
    $template = str_replace("{icon}", $icon, $template);
    $template = str_replace("{kategorie_name}", $cat[cat_name], $template);
    $navi .= $template;
}
unset($valid_ids);

/////////////////////////////
// Dateivorschau erzeugen ///
/////////////////////////////

unset($dateien);
if ($show == true)
{
    $index = mysql_query("SELECT dl_name,
                                 dl_id,
                                 dl_text,
                                 dl_date,
                                 cat_id
                          FROM ".$global_config_arr[pref]."dl
                          $query dl_open = 1
                          ORDER BY dl_name", $db);
                          
    while ($dl_arr = mysql_fetch_assoc($index))
    {
        $dl_arr[dl_text] = killfs($dl_arr[dl_text]);
        $dl_arr[dl_text] = truncate_string($dl_arr[dl_text], 250, "...");
        $dl_arr[dl_date] = date("d.m.Y" , $dl_arr[dl_date]);
        $index3 = mysql_query("select cat_name from ".$global_config_arr[pref]."dl_cat where cat_id = '$dl_arr[cat_id]'", $db);
        $dl_arr[cat_name] = stripslashes(mysql_result($index3, 0, "cat_name"));
        $index2 = mysql_query("select dl_datei_preview from ".$global_config_arr[pref]."template where id = '$global_config_arr[design]'", $db);
        $template = stripslashes(mysql_result($index2, 0, "dl_datei_preview"));
        $template = str_replace("{url}", "?go=dlfile&amp;fileid=".$dl_arr[dl_id], $template);
        $template = str_replace("{name}", $dl_arr[dl_name], $template);
        $template = str_replace("{text}", $dl_arr[dl_text], $template);
        $template = str_replace("{datum}", $dl_arr[dl_date], $template);
        $template = str_replace("{cat}", $dl_arr[cat_name], $template);
            
        $dateien .= $template;
    }
    unset($dl_arr);
}

/////////////////////////////
///// Template aufbauen /////
/////////////////////////////

// Suchfeld auslesen
$index = mysql_query("select dl_search_field from ".$global_config_arr[pref]."template where id = '$global_config_arr[design]'", $db);
$suchfeld = stripslashes(mysql_result($index, 0, "dl_search_field"));

$index = mysql_query("select dl_body from ".$global_config_arr[pref]."template where id = '$global_config_arr[design]'", $db);
$template = stripslashes(mysql_result($index, 0, "dl_body"));
$template = str_replace("{navigation}", $navi, $template);
 
$template = str_replace("{dateien}", $dateien, $template); 
$template = str_replace("{suchfeld}", $suchfeld, $template); 
$template = str_replace("{titel}", $page_titel, $template);


if ($_GET[catid]!=0) {
   $template = str_replace("{input_cat}", '<input type="hidden" name="catid" value="'.$_GET[catid].'">', $template);
   $template = str_replace("{all_url}", "?go=download&catid=$_GET[catid]", $template); }
else {
   $template = str_replace("{input_cat}", '<input type="hidden" name="catid" value="all">', $template);
   $template = str_replace("{all_url}", "?go=download&catid=all", $template); }
if (isset($_GET[keyword]))
   $template = str_replace("{keyword}", $_GET[keyword], $template);
else
   $template = str_replace("{keyword}", "", $template);

unset($navi);
unset($dateien);
unset($suchfeld);

?>