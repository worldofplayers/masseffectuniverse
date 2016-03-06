<?php
global $db, $global_config_arr;

require "../login.inc.php"; // DB Connection File

	if ($db) {
		$xml = '';
		$host = $global_config_arr[virtualhost] != '' ? $global_config_arr[virtualhost] : "http://example.com";
		$host = substr($host, -1) == '/' ? $host : $host.'/';

		$query = "SELECT article_url, article_date FROM ".$global_config_arr[pref]."articles ORDER BY article_id ASC";
		$result = mysql_query($query, $db);


		$xml .= '<?xml version="1.0" encoding="UTF-8"?>';
		$xml .= "\n".'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

		$xml .= '
    <url>
        <loc>'.$host.'</loc>
        <lastmod>'.date('Y-m-d', time()).'</lastmod>
        <priority>1.0</priority>
        <changefreq>hourly</changefreq>
    </url>';		
		
		while($item = mysql_fetch_array($result)) {
			$xml .= '
    <url>
        <loc>'.$host.''.$item['article_url'].'.html</loc>
        <lastmod>'.date('Y-m-d', $item['article_date'] == 0 ? time() : $item['article_date']).'</lastmod>
        <priority>1.0</priority>
        <changefreq>weekly</changefreq>
    </url>';
		}

		$xml .= "\n</urlset>";

		file_put_contents("sitemap_articles.xml", $xml);
	}
?>
