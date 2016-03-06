<?php
global $db, $global_config_arr;

require "../login.inc.php"; // DB Connection File
	
	function urlThemenseite($name)
	{
		global $global_config_arr, $host;
	
		include("../data/$name.php");
		$lastnewsdate = mysql_fetch_assoc(mysql_query("SELECT MAX(news_date) AS maxdate FROM ".$global_config_arr[pref]."news WHERE " . $news_cat_id_where));
		return '
    <url>
        <loc>'.$host . $name . '.html</loc>
        <lastmod>'.date('Y-m-d', $lastnewsdate[maxdate] == 0 ? time() : $lastnewsdate[maxdate]).'</lastmod>
        <priority>1.0</priority>
        <changefreq>daily</changefreq>
    </url>';		
	}

	if ($db) {
		$xml = '';
		$host = $global_config_arr[virtualhost] != '' ? $global_config_arr[virtualhost] : "http://example.com";
		$host = substr($host, -1) == '/' ? $host : $host.'/';

		$query = "SELECT news_id, news_date FROM ".$global_config_arr[pref]."news WHERE news_active = 1 ORDER BY news_id ASC";
		$result = mysql_query($query, $db);


		$xml .= '<?xml version="1.0" encoding="UTF-8"?>';
		$xml .= "\n".'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
		
		foreach (array("mass_effect", "mass_effect_2", "mass_effect_3", "mass_effect_universum") as $thema)
			$xml .= urlThemenseite($thema);

		while($item = mysql_fetch_array($result)) {
			$xml .= '
    <url>
        <loc>'.$host.'comments--id-'.$item['news_id'].'.html</loc>
        <lastmod>'.date('Y-m-d', $item['news_date'] == 0 ? time() : $item['news_date']).'</lastmod>
        <priority>1.0</priority>
        <changefreq>weekly</changefreq>
    </url>';
		}

		$xml .= "\n</urlset>";

		file_put_contents("sitemap_news.xml", $xml);
	}
?>
