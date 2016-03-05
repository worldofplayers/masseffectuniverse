<?php

$url = htmlspecialchars($_GET['go']);
$average = "";

if($url == "comments"){
	$id = $_GET['id'];
	if(is_numeric($id)) {
		$index = mysql_query ( "
							SELECT `news_id`, `rating`, `total_rating`, `total_ratings`
							FROM `fs2_news`
							WHERE `news_id`='$id'
		", $db);
		
		$title = "news";
		$row = mysql_fetch_array($index);
		$id = $row['news_id'];
		$rating = $row['rating']; 
		$total_rating = $row['total_rating'];
		$total_ratings = $row['total_ratings'];
		
		$average .= " &empty; " . $rating . " (ermittelt aus " . $total_ratings . " Stimmen)";
	}
}
else{
	$index = mysql_query ( "
                        SELECT `article_id`, `rating`, `total_rating`, `total_ratings`
                        FROM `fs2_articles`
						WHERE `article_url`='$url'
	", $db);
	
	$title = "article";
	$row = mysql_fetch_array($index);
	$id = $row['article_id'];
	$rating = $row['rating']; 
	$total_rating = $row['total_rating'];
	$total_ratings = $row['total_ratings'];
}

 if($rating > 0)   { $hover1 = "class='hover'"; }
 if($rating > 1.5) { $hover1 = "class='hover'"; } 
 if($rating > 2.5) { $hover1 = "class='hover'"; }
 if($rating > 3.5) { $hover1 = "class='hover'"; }  
 if($rating > 4.5) { $hover1 = "class='hover'"; }   
 
 $template = <<<DOC
    <div id="rate" class="floatleft">
	   <div class="starrating" id="rating_$id" title="$title"> 
	      <span class="star_1" title="Mies!"><img src="styles/lightfrog/star_blank.png" alt="Mies!" $hover1 /></span>
	      <span class="star_2" title="Naja..."><img src="styles/lightfrog/star_blank.png" alt="Naja..." $hover2 /></span>
	      <span class="star_3" title="In Ordnung!"><img src="styles/lightfrog/star_blank.png" alt="In Ordnung!" $hover3 /></span>
	      <span class="star_4" title="Gut."><img src="styles/lightfrog/star_blank.png" alt="Gut." $hover4 /></span>
	      <span class="star_5" title="Top!"><img src="styles/lightfrog/star_blank.png" alt="Top!" $hover5 /></span>
		  <span style="position: relative; left: 15px; top: -2px;">$average</span>
	   </div>
	   <br>
	   <span><a href="?go=topoderflop">Alle Wertungen im Ranking sehen</a></span>
   </div>
   <br>
   <span style="clear:both;"></span>
DOC;

?>