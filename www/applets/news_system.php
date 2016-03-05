<?php
setlocale (LC_ALL, 'de_DE@euro', 'de_DE', 'de', 'ge');

$template = "";
$zaehler = 0;
$index = mysql_query("select * from ".$global_config_arr[pref]."news_config", $db);
$config_arr = mysql_fetch_assoc($index);
$limit = $config_arr[num_news];

$timestamp = time();

$news_long = mysql_query("
                        SELECT news_id, news_title, news_date, news_prev, rating
                        FROM fs2_news
						WHERE news_active = 1 AND news_date <=" . $timestamp ."
						ORDER BY news_date DESC
						LIMIT 3
", $db);

while($row = mysql_fetch_array($news_long)){

	$title = $row['news_title'];
	$prev_text = $row['news_prev'];
	$id = $row['news_id'];
	$date = $row['news_date'];
	$rating = $row['rating'];

    switch ($config_arr[html_code])
    {
        case 1:
            $html = false;
            break;
        case 2:
            $html = true;
            break;
        case 3:
            $html = false;
            break;
        case 4:
            $html = true;
            break;
    }
    switch ($config_arr[fs_code])
    {
        case 1:
            $fs = false;
            break;
        case 2:
            $fs = true;
            break;
        case 3:
            $fs = false;
            break;
        case 4:
            $fs = true;
            break;
    }
    switch ($config_arr[para_handling])
    {
        case 1:
            $para = false;
            break;
        case 2:
            $para = true;
            break;
        case 3:
            $para = false;
            break;
        case 4:
            $para = true;
            break;
    }

    $prev_text = fscode ( $prev_text, $fs, $html, $para );
    $title = killhtml ( $title );
	
	$comments = mysql_query("SELECT comment_id FROM ".$global_config_arr[pref]."news_comments WHERE news_id = $id", $db);
	$comments_num = mysql_num_rows($comments);
	if($comments_num == 1)
		$kommentar = "Kommentar";
	else
		$kommentar = "Kommentare";
	$datum = strftime("%A, %d.%m. %H:%M", $date);
	
	if($rating > 0)
		$rating = "<img src=\"styles/lightfrog/" . $rating . "stars.png\" alt=\"Bewertung\"> | ";
	else 
		$rating = "";
	
	

	$template .= "<div class=\"content_beg\"></div><div class=\"content\">";
	$template .= "<img class=\"news_title_prev_img\" src=\"styles/lightfrog/inhalt_titel.png\"><div class=\"news_title_prev\"><a class=\"news_titel\" href=\"comments--id-{$id}.html\">" . $title . "</a></div>";
	$template .= "<div class=\"news\">";
	$template .= "<div class=\"news_prev_text\">" . $prev_text . "</div>";
	$template .= "<br><a href=\"comments--id-{$id}.html\">mehr...</a>";
	$template .= "</div>";
	$template .= "<div style=\"float:right;\"><img src=\"styles/lightfrog/trenner2_180.png\"></div><br>
			      <div style=\"clear:right;float:right;\">" . $datum . " | " . $rating . "<a href=\"comments--id-{$id}.html#comment\">" . $comments_num . "</a> " . $kommentar . "</div>";
	$template .= "</div><div id=\"content_ende\"></div>";

}

$limit -= 3;

$news_short = mysql_query("
                        SELECT news_id, news_title, news_date
                        FROM fs2_news
						WHERE news_active = 1 AND news_date <=" . $timestamp ."
						ORDER BY news_date DESC
						LIMIT 3, {$limit}
", $db);

$template .= "<div class=\"content_beg\"></div><div class=\"content\">";

while($row = mysql_fetch_array($news_short)){

	$date = $row['news_date'];
	$title = $row['news_title'];
	$id = $row['news_id'];
	$title = killhtml ($title);
	$tag = strftime("%A, %d.%m", $date);
	$zeit = strftime("%H:%M", $date);
	
	$comments = mysql_query("SELECT comment_id FROM ".$global_config_arr[pref]."news_comments WHERE news_id = $id", $db);
	$comments_num = mysql_num_rows($comments);

	/*News-Tabellen-Start*/
	
	if($zaehler > 0 && $tag != $news_block)
		$template .= "</table><span class=\"link\" style=\"font-weight: bold;\">" . $tag . "</span><table>";
	
	$news_block = $tag;

	if($zaehler == 0){
		$template .= "<div id=\"news_top\"></div><div class=\"news_forum_container\">";
		$template .= "<div id=\"news_left\"><span class=\"link\" style=\"font-weight: bold;\">" . $tag . "</span><table>";
	}

	$template .= "<tr><td valign=\"top\"><span class=\"date1\">" . $zeit . "</span></td><td><a class=\"news_titel\" href=\"comments--id-{$id}.html\">" . $title . "</a> (" . $comments_num . ")</td></tr>";
	
	if($zaehler == (int)($limit/2))
		$template .= "</table></div><div id=\"news_right\"><table>";
	
	
	$zaehler++;
	
	if($zaehler == $limit){
		$template .= "</table></div></div><div class=\"news_forum_bot\"></div>";
		
		/*Foren-Ticker*/
		
		$template .= "<br><div id=\"forum_top\"></div><div class=\"news_forum_container\"><table>";
		
		$foren = array(844, 5, "Mass Effect 4",
					   507, 8, "Die Shepard-Trilogie: Diskussion",				   
					   772, 6, "Multiplayer",
					   773, 6, "Mass Effect 3 - Hilfe",
					   665, 8, "Mass Effect 2 - Hilfe",
					   508, 5, "ME1-Hilfe"
					   );
					   
					   
		for($i = 0; $i < /*count($foren)*/9; $i++){
		
			$xml = simplexml_load_file("http://forum.worldofplayers.de/forum/external.php?type=xml&lastpost=true&forumids=" . $foren[$i]);
			$j = 1;
			
			foreach($xml->thread as $thread){
				if($j == 1)
					$template .= "</table><table id=\"forum_" . $i . "\"><tr><td colspan=\"2\" style=\" font-weight: bold;\"><a href=\"http://forum.worldofplayers.de/forum/forums/" . $foren[$i] . "\">" . $foren[$i+2] . "</a></td></tr>";
					
				$date = htmlspecialchars((string)$thread->date);
				$date = substr($date, 0, -4);
				$template .= "<tr><td valign=\"top\">
							  <span class=\"date1\">" . $date . "</span></td>
							  <td><a class=\"news_titel\" href=\"http://www.forum.worldofplayers.de/forum/threads/" . htmlspecialchars(utf8_decode((string)$thread["id"])) . "\">" . htmlspecialchars(utf8_decode((string)$thread->title)) . "</a>
							  </td></tr>";
							  
				if($j == $foren[$i+1])
					break;
					
				$j++;
			}
			
			$i = $i +2;
		}
		$template .= "</table><span style=\"clear: both;\"></span></div><div class=\"news_forum_bot\"></div>";
		$template .= "<span style=\"float: right;\">&gt; <a href=\"news_search.html\">Alle News im Archiv</a> &gt; <a href=\"http://forum.worldofplayers.de/forum/forums/506\">Alle Foren</a></span>";
		$template .= "</div><div class=\"content_ende\"></div>";
	}
}
?>