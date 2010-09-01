<?php
print_r ( $_REQUEST );
// Security Functions
$_REQUEST['in'] = ( !is_array ( $_REQUEST['in'] ) ) ? array () : $_REQUEST['in'];
$_REQUEST['keyword'] = trim ( $_REQUEST['keyword'] );

// Load Config Array
$config_arr = $sql->getData ( "search_config", "*", "", 1 );

// Create SQL Queries
if ( strlen ( $_REQUEST['keyword'] ) >= $config_arr['search_min_length'] && ( count ( $_REQUEST['in'] ) >= 1 ) ) {

    // Create Search class
    $theSearch = new Search ();
    $theSearch->makeSearch ( $_REQUEST['keyword'] );

}

if ( $_REQUEST['keyword'] == "" ) {
    $_REQUEST['in'] = array ( "news", "articles", "downloads" );
} else {
    // Dynamic Title Settings
    $global_config_arr['dyn_title_page'] = $TEXT->get("download_search_for") . ' "' . kill_replacements ( $_REQUEST['keyword'], TRUE ) . '"';
}


// More Results Template
$more_results_template = new template();
$more_results_template->setFile("0_search.tpl");
$more_results_template->load("MORE_RESULTS");

// No Results Template
$no_results_template = new template();
$no_results_template->setFile("0_search.tpl");
$no_results_template->load("NO_RESULTS");
$no_results_template = $no_results_template->display ();

// Get News Entries
if ( isset ( $results_arr['news'] ) ) {
    // Security Function
    $news_entries = "";
    $replace_arr = array();
                                         
    // Get max. num of data sets to select
    $num_data_sets = min ( $config_arr['search_num_previews'], count ( $results_arr['news'] ) );

    // Get Data from DB
    $index = mysql_query ( "
                            SELECT `news_id`, `news_title`, `news_date`
                            FROM `".$global_config_arr['pref']."news`
                            WHERE `news_id` IN(" . implode ( ",", get_id_list_from_result_arr ( $results_arr['news'], $num_data_sets  ) ) . ")
                            AND `news_date` <= ".time()."
                            AND `news_active` = 1
                            ORDER BY `news_date` DESC
    ", $db );
    while ( $data_arr = mysql_fetch_assoc ( $index ) ) {
        settype ( $data_arr['news_id'], "integer" );
        $replace_arr[] = array (
            "id" => $data_arr['news_id'],
            "title" => $data_arr['news_title'],
            "date" => $data_arr['news_date'],
            "num_results" => $results_arr['news'][$data_arr['news_id']],
        );
    }

    // Sort Data Array by Counter and Date
    $replace_arr = sort_replace_arr ( $replace_arr );
    
    // Get More Results Template
    if ( count ( $replace_arr ) > $config_arr['search_num_previews'] ) {
        $news_more = $more_results_template;
        $news_more->tag("main_search_url", "?go=news_search&amp;keyword=".implode ( "+", $keyword_arr ) );
        $news_more = $news_more->display ();
    } else {
        $news_more = "";
    }

    // Create Template for Entries
    $news_num_results = 0;
    for ( $i = 0; $i < min ( $num_data_sets, count ( $replace_arr ) ); $i++ ) {
        $data = $replace_arr[$i];
        $date_formated = date_loc ( $global_config_arr['date'], $data['date'] );

        if ( $data['date'] != 0 ) {
            // Get Date Template
            $template = new template();
            $template->setFile("0_search.tpl");
            $template->load("RESULT_DATE_TEMPLATE");
            $template->tag("date", $date_formated );
            $date_template = $template->display ();
        } else {
            $date_template = "";
        }

        // Get Template
        $template = new template();
        $template->setFile("0_search.tpl");
        $template->load("RESULT_LINE");

        $template->tag("id", $data['id'] );
        $template->tag("title", stripslashes ( $data['title'] ) );
        $template->tag("url", "?go=comments&amp;id=" . $data['id'] );
        $template->tag("date", $date_formated );
        $template->tag("date_template", $date_template );
        $template->tag("num_matches", $data['num_results'] );

        $news_entries .= $template->display ();
        $news_num_results = $i;
    }
    $news_entries = ( count ( $replace_arr ) >= 1 ) ? $news_entries : $no_results_template;
    $news_num_results++;
} else {
    $news_entries = $no_results_template;
    $news_num_results = 0;
    $news_more = "";
}

// Get Articles Entries
if ( isset ( $results_arr['articles'] ) ) {
    // Security Function
    $articles_entries = "";
    $replace_arr = array();
    
    // Get max. num of data sets to select
    $num_data_sets = min ( $config_arr['search_num_previews'], count ( $results_arr['articles'] ) );
    $num_data_sets = count ( $results_arr['articles'] ); // Remove Line when articles_search implemented

    // Get Data from DB
    $index = mysql_query ( "
                            SELECT `article_id`, `article_url`, `article_title`, `article_date`
                            FROM `".$global_config_arr['pref']."articles`
                            WHERE `article_id` IN(" . implode ( ",", get_id_list_from_result_arr ( $results_arr['articles'], $num_data_sets  ) ) . ")
                            ORDER BY `article_date` DESC
    ", $db );
    while ( $data_arr = mysql_fetch_assoc ( $index ) ) {
        settype ( $data_arr['news_id'], "integer" );
        $article_arr['article_url'] = ( $article_arr['article_url'] == "" ) ? "articles&amp;id=".$article_arr['article_id'] : stripslashes ( $article_arr['article_url'] );
        $replace_arr[] = array (
            "id" => $data_arr['article_id'],
            "title" => $data_arr['article_title'],
            "url" => $data_arr['article_url'],
            "date" => $data_arr['article_date'],
            "num_results" => $results_arr['articles'][$data_arr['article_id']],
        );
    }
    
    // Sort Data Array by Counter and Date
    $replace_arr = sort_replace_arr ( $replace_arr );
    
    // Get More Results Template
    if ( count ( $replace_arr ) > $config_arr['search_num_previews'] ) {
        $articles_more = $more_results_template;
        $articles_more->tag("main_search_url", "?go=articles_search&amp;keyword=".implode ( "+", $keyword_arr ) );
        $articles_more = $articles_more->display ();
    } else {
        $articles_more = "";
    }
    $articles_more = ""; // Remove Line when articles_search implemented

    // Create Template for Entries
    $articles_num_results = 0;
    for ( $i = 0; $i < min ( $num_data_sets, count ( $replace_arr ) ); $i++ ) {
        $data = $replace_arr[$i];
        $date_formated = date_loc ( $global_config_arr['date'], $data['date'] );

        if ( $data['date'] != 0 ) {
            // Get Date Template
            $template = new template();
            $template->setFile("0_search.tpl");
            $template->load("RESULT_DATE_TEMPLATE");
            $template->tag("date", $date_formated );
            $date_template = $template->display ();
        } else {
            $date_template = "";
        }

        // Get Template
        $template = new template();
        $template->setFile("0_search.tpl");
        $template->load("RESULT_LINE");

        $template->tag("id", $data['id'] );
        $template->tag("title", stripslashes ( $data['title'] ) );
        $template->tag("url", "?go=" . $data['url'] );
        $template->tag("date", $date_formated );
        $template->tag("date_template", $date_template );
        $template->tag("num_matches", $data['num_results'] );

        $articles_entries .= $template->display ();
        $articles_num_results = $i;
    }
    $articles_entries = ( count ( $replace_arr ) >= 1 ) ? $articles_entries : $no_results_template;
    $articles_num_results++;
} else {
    $articles_entries = $no_results_template;
    $articles_num_results = 0;
    $articles_more = "";
}


// Get Download Entries
if ( isset ( $results_arr['dl'] ) ) {
    // Security Function
    $downloads_entries = "";
    $replace_arr = array();
    
    // Get max. num of data sets to select
    $num_data_sets = min ( $config_arr['search_num_previews'], count ( $results_arr['dl'] ) );

    // Get Data from DB
    $index = mysql_query ( "
                            SELECT `dl_id`, `dl_name`, `dl_date`
                            FROM `".$global_config_arr['pref']."dl`
                            WHERE `dl_id` IN(" . implode ( ",", get_id_list_from_result_arr ( $results_arr['dl'], $num_data_sets  ) ) . ")
                            AND `dl_open` = 1
                            ORDER BY `dl_date` DESC
    ", $db );
    while ( $data_arr = mysql_fetch_assoc ( $index ) ) {
        settype ( $data_arr['dl_id'], "integer" );
        $replace_arr[] = array (
            "id" => $data_arr['dl_id'],
            "title" => $data_arr['dl_name'],
            "date" => $data_arr['dl_date'],
            "num_results" => $results_arr['dl'][$data_arr['dl_id']],
        );
    }

    // Sort Data Array by Counter and Date
    $replace_arr = sort_replace_arr ( $replace_arr );

    // Get More Results Template
    if ( count ( $replace_arr ) > $config_arr['search_num_previews'] ) {
        $downloads_more = $more_results_template;
        $downloads_more->tag("main_search_url", "?go=download&amp;cat_id=all&amp;keyword=".implode ( "+", $keyword_arr ) );
        $downloads_more = $downloads_more->display ();
    } else {
        $downloads_more = "";
    }

    // Create Template for Entries
    $downloads_num_results = 0;
    for ( $i = 0; $i < min ( $num_data_sets, count ( $replace_arr ) ); $i++ ) {
        $data = $replace_arr[$i];
        $date_formated = date_loc ( $global_config_arr['date'], $data['date'] );

        if ( $data['date'] != 0 ) {
            // Get Date Template
            $template = new template();
            $template->setFile("0_search.tpl");
            $template->load("RESULT_DATE_TEMPLATE");
            $template->tag("date", $date_formated );
            $date_template = $template->display ();
        } else {
            $date_template = "";
        }

        // Get Template
        $template = new template();
        $template->setFile("0_search.tpl");
        $template->load("RESULT_LINE");

        $template->tag("id", $data['id'] );
        $template->tag("title", stripslashes ( $data['title'] ) );
        $template->tag("url", "?go=dlfile&amp;id=" . $data['id'] );
        $template->tag("date", $date_formated );
        $template->tag("date_template", $date_template );
        $template->tag("num_matches", $data['num_results'] );

        $downloads_entries .= $template->display ();
        $downloads_num_results = $i;
    }
    $downloads_entries = ( count ( $replace_arr ) >= 1 ) ? $downloads_entries : $no_results_template;
    $downloads_num_results++;
} else {
    $downloads_entries = $no_results_template;
    $downloads_num_results = 0;
    $downloads_more = "";
}


// Results Template
$results_template = new template();
$results_template->setFile("0_search.tpl");
$results_template->load("RESULTS_BODY");

// News Template
if ( trim ( $_REQUEST['keyword'] ) != "" && $_REQUEST['in_news'] === TRUE ) {
    // Get Template
    $template = $results_template;
    $template->tag("type_title", $TEXT->get("search_news_title") );
    $template->tag("results", $news_entries );
    $template->tag("num_results", $news_num_results );
    $template->tag("more_results", $news_more );
    $news_template = $template->display ();
} else {
    $news_template = "";
}

// Articles Template
if ( trim ( $_REQUEST['keyword'] ) != "" && $_REQUEST['in_articles'] === TRUE ) {
    // Get Template
    $template = $results_template;
    $template->tag("type_title", $TEXT->get("search_articles_title") );
    $template->tag("results", $articles_entries );
    $template->tag("num_results", $articles_num_results );
    $template->tag("more_results", $articles_more );
    $articles_template = $template->display ();
} else {
    $articles_template = "";
}

// Downloads Template
if ( trim ( $_REQUEST['keyword'] ) != "" && $_REQUEST['in_downloads'] === TRUE ) {
    // Get Template
    $template = $results_template;
    $template->tag("type_title", $TEXT->get("search_downloads_title") );
    $template->tag("results", $downloads_entries );
    $template->tag("num_results", $downloads_num_results );
    $template->tag("more_results", $downloads_more );
    $downloads_template = $template->display ();
} else {
    $downloads_template = "";
}


// Search Template
$_REQUEST['in_news'] = ( $_REQUEST['in_news'] ) ? "checked" : "";
$_REQUEST['in_articles'] = ( $_REQUEST['in_articles'] ) ? "checked" : "";
$_REQUEST['in_downloads'] = ( $_REQUEST['in_downloads'] ) ? "checked" : "";
$_REQUEST['keyword'] = kill_replacements ( $_REQUEST['keyword'], TRUE );

// Get Template
$template = new template();
$template->setFile("0_search.tpl");
$template->load("SEARCH");

$template->tag("keyword", $_REQUEST['keyword'] );
$template->tag("search_in_news", $_REQUEST['in_news'] );
$template->tag("search_in_articles", $_REQUEST['in_articles'] );
$template->tag("search_in_downloads", $_REQUEST['in_downloads'] );

$search_template = $template->display ();


// Get Main Template
$template = new template();
$template->setFile("0_search.tpl");
$template->load("BODY");

$template->tag("search", $search_template );
$template->tag("news", $news_template );
$template->tag("articles", $articles_template );
$template->tag("downloads", $downloads_template );

$template = $template->display ();
?>