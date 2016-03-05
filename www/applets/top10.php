<?php
$cat = $_GET['cat'];
$ja_nein = "n";

if(empty($cat)) { 
	$table = "SELECT total_ratings, article_title, article_url, rating";
	$from = "fs2_articles";
	$wahl = "rating"; 
	$sort = "DESC"; 
	$where = "WHERE rating >=4  AND rating <=5 "; 
	$text = "<span style='font-size:125%;'>Beliebteste Artikel</span><br><img src='styles/lightfrog/5stars.png'> | <img src='styles/lightfrog/4stars.png'>";
	$jn = "j";
}
else {
		if($cat == 1) {
			$table = "SELECT total_ratings, article_title, article_url, rating";
			$from = "fs2_articles";
			$wahl = "total_ratings"; 
			$sort = "DESC"; 
			$text = "<span style='font-size:125%;'>Meiste Bewertungen</span>"; 
			$limit = "LIMIT 15"; 
			$jn = "j";
		}
		else if($cat == 2) {
			$table = "SELECT total_ratings, news_title, news_id, rating";
			$from = "fs2_news";
			$wahl = "rating"; 
			$sort = "DESC"; 
			$where = "WHERE rating > 0 AND rating <= 5"; 
			$text = "<span style='font-size:125%;'>News</span><br>";
			$jn = "j";
		}
		else if($cat > 2 OR $cat < 1){
			$template = "<span style='font-size:125%;'>Klicke oben auf einen Link zur Auswahl einer Option!</span>";
			$jn = "n";
		}
	}
if($jn === "j"){
	$index = mysql_query ( "$table
							FROM $from
							$where
							ORDER BY $wahl $sort
							$limit
	", $db);
	
	$template = $text;
	$template .= "<br><br><table>";
	$i = 1;
	while($rows = mysql_fetch_array($index)) {
			
		$template .= "<tr><td>{$i}.</td><td><a style='padding-right: 15px;' href='";
		if($cat == 2){
			$template .= "comments--id-" . $rows[news_id] . ".html";
			$title = $rows[news_title];
		}
		else{
			$template .= $rows[article_url] . ".html";
			$title = $rows[article_title];
		}
		$template .= "'>{$title}</a></td><td style='padding-right: 25px;'>Votings insg.: {$rows[total_ratings]}</td><td>Sterne: <img src='styles/lightfrog/{$rows[rating]}stars.png' alt='Bewertung' /></td></tr>";
		$i++;
		}
	$template .= "</table>";
}
?>