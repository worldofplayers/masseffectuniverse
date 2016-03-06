<?php
global $db, $global_config_arr;

if (isset($_POST['rating']) && isset($_POST['id']) && isset($_POST['art'])) {

	$rating = (int)$_POST['rating'];
	$id = (int)$_POST['id'];
	$art = htmlspecialchars($_POST['art']);

	if(is_numeric($rating) && is_numeric($id)){

		if($art == "news"){
			$query = mysql_query("SELECT rating, total_rating, total_ratings FROM fs2_news WHERE news_id = '".$id."'", $db) or die(mysql_error());
		}
		elseif($art == "article"){
			$query = mysql_query("SELECT rating, total_rating, total_ratings FROM fs2_articles WHERE article_id = '".$id."'", $db) or die(mysql_error());
		}
		else{
			exit();
		}

		while($row = mysql_fetch_array($query)) {

			if($rating > 5 || $rating < 1) {
				//$template = "<div class='highlight'>Bewertung muss zwischen 1 und 5 liegen!</div>";
				echo"<div class='highlight'>Bewertung muss zwischen 1 und 5 liegen!</div>";
			}
			
			elseif(isset($_COOKIE['rated'.$id])) {
				//$template = "<div class='highlight'>Bereits abgestimmt!</div>";
				echo"<div class='highlight'>Bereits abgestimmt!</div>";
			}
			else {

				setcookie("rated".$id, $id, time()+60*60*24*365);

				$total_ratings = $row['total_ratings'];
				$total_rating = $row['total_rating'];
				$current_rating = $row['rating'];

				$new_total_rating = $total_rating + $rating;
				$new_total_ratings = $total_ratings + 1;
				$new_rating = $new_total_rating / $new_total_ratings;
				

				//DB
				
				if($art == "news"){
					mysql_query("UPDATE fs2_news SET total_rating = '".$new_total_rating."' WHERE news_id = '".$id."'", $db) or die(mysql_error());
					mysql_query("UPDATE fs2_news SET rating = '".$new_rating."' WHERE news_id = '".$id."'", $db) or die(mysql_error());
					mysql_query("UPDATE fs2_news SET total_ratings = '".$new_total_ratings."' WHERE news_id = '".$id."'", $db) or die(mysql_error());

				}
				else {
					mysql_query("UPDATE fs2_articles SET total_rating = '".$new_total_rating."' WHERE article_id = '".$id."'", $db) or die(mysql_error());
					mysql_query("UPDATE fs2_articles SET rating = '".$new_rating."' WHERE article_id = '".$id."'", $db) or die(mysql_error());
					mysql_query("UPDATE fs2_articles SET total_ratings = '".$new_total_ratings."' WHERE article_id = '".$id."'", $db) or die(mysql_error());
				}
				

				echo"<div class='highlight'>Stimme erfolgreich gewertet!</div>";
				//$template = "<div class='highlight'>Stimme erfolgreich gewertet!</div>";
			}
                    }
                }	
		else{
                    exit();
		}
}
?>
