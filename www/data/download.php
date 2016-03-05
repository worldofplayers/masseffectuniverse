<?php
// Set canonical parameters
$FD->setConfig('info', 'canonical', array('cat_id', 'keyword'));

// Load Config Array
$FD->loadConfig('downloads');
$config_arr = $FD->configObject('downloads')->getConfigArray();

if (!isset($_GET['cat_id']) && isset($_GET['catid'])) {
    $_GET['cat_id'] = $_GET['catid'];
}

if ( !isset ( $_GET['cat_id'] ) ) {
   $show = FALSE;
   $_GET['cat_id'] = 0;
} else {
    $show = TRUE;
    if ( $_GET['cat_id'] == 'all' ) {
        $_GET['cat_id'] = 0;
    }
}
settype($_GET['cat_id'], 'integer');

if (isset($_GET['keyword']) && $_GET['keyword'] != '')
{
    $sql_keyword = substr($FD->sql()->conn()->quote($_GET['keyword']), 1, -1);
    $_GET['keyword'] = kill_replacements ( $_GET['keyword'], TRUE );
    if ($_GET['cat_id'] != 0) {
        $query = "WHERE (dl_text LIKE '%".$sql_keyword."%' OR dl_name LIKE '%".$sql_keyword."%') AND cat_id = ".$_GET['cat_id'].' AND';
        $page_titel = ' - ';
    } else {
        $query = "WHERE dl_text LIKE '%".$sql_keyword."%' OR dl_name LIKE '%".$sql_keyword."%' AND";
    }
    $page_titel .= $FD->text("frontend", "download_search_for") . ' "' . $_GET['keyword'] . '"';
} else {
    $_GET['keyword'] = '';
    $query = "WHERE cat_id = $_GET[cat_id] AND";
    if ($_GET['cat_id'] == 0) {
       $query = 'WHERE';
       $page_titel = $FD->text('frontend', 'download_all_downloads');
    }

}


/////////////////////////////
//// Navigation erzeugen ////
/////////////////////////////

$valid_ids = array();
get_dl_categories ($valid_ids, $_GET['cat_id'], $config_arr['dl_show_sub_cats'] );

$navi_lines = '';
if (!isset($page_titel))
{
  $page_titel = '';
}
foreach ($valid_ids as $cat) {
    if ($cat['cat_id'] == $_GET['cat_id']) {
        $icon_url = $FD->config('virtualhost').'styles/'.$FD->config('style').'/icons/folder_open.gif';
        $page_titel = $cat['cat_name'] . $page_titel;
    } else {
        $icon_url = $FD->config('virtualhost').'styles/'.$FD->config('style').'/icons/folder.gif';
    }
    // Get Navigation Line Template
    $template = new template();
    $template->setFile('0_downloads.tpl');
    $template->load('NAVIGATION_LINE');

    $template->tag('icon_url', $icon_url );
    $template->tag('cat_url', url('download', array('cat_id' => $cat['cat_id'])));
    $template->tag('cat_name', $cat['cat_name'] );

    $template = $template->display ();
    $navi_lines .= str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $cat['level']) . $template;
}

// Get Navigation Template
$template = new template();
$template->setFile('0_downloads.tpl');
$template->load('NAVIGATION_BODY');
$template->tag('lines', $navi_lines );
$navi = $template->display ();


/////////////////////////////
// Dateivorschau erzeugen ///
/////////////////////////////

// Get No Previews Template
$template = new template();
$template->setFile('0_downloads.tpl');
$template->load('NO_PREVIEW_LINE');
$dateien = $template->display ();


if ($show == TRUE) {
    $index = $FD->sql()->conn()->query(
                  'SELECT COUNT(*) AS anzahl
                   FROM '.$FD->config('pref')."dl
                   $query dl_open = 1");
    $num_rows = $index->fetchColumn();
    $index = $FD->sql()->conn()->query('SELECT dl_name,
                                 dl_id,
                                 dl_text,
                                 dl_date,
                                 cat_id
                          FROM '.$FD->config('pref')."dl
                          $query dl_open = 1
                          ORDER BY dl_name");
    $filecount = $index->rowCount();

    if ( $num_rows > 0 ) {
        $dateien = '';
    }

    while ($dl_arr = $index->fetch(PDO::FETCH_ASSOC)) {
        $dl_arr['dl_text'] = killfs($dl_arr['dl_text']);
        $dl_arr['dl_text'] = truncate_string($dl_arr['dl_text'], 250, '...');
        $dl_arr['dl_date'] = date_loc( $FD->config('date') , $dl_arr['dl_date'] );
        $index3 = $FD->sql()->conn()->query('SELECT cat_name FROM '.$FD->config('pref')."dl_cat WHERE cat_id = '$dl_arr[cat_id]'" );
        $dl_arr['cat_name'] = $index3->fetchColumn(); //cat_name

        // Get Template
        $template = new template();
        $template->setFile('0_downloads.tpl');
        $template->load('PREVIEW_LINE');

        $template->tag('title', $dl_arr['dl_name'] );
        $template->tag('url', url('dlfile', array('id' => $dl_arr['dl_id'])));
        $template->tag('cat_name', $dl_arr['cat_name'] );
        $template->tag('date', $dl_arr['dl_date'] );
        $template->tag('text', $dl_arr['dl_text'] );

        $template = $template->display ();
        $dateien .= $template;
    }

    // Get Template
    $template = new template();
    $template->setFile('0_downloads.tpl');
    $template->load('PREVIEW_LIST');

    $template->tag('entries', $dateien );

    $template = $template->display ();
    $preview_list = $template;

} else {
    $preview_list = '';
}

/////////////////////////////
///// Template aufbauen /////
/////////////////////////////

// Suchfeld auslesen
if ( is_numeric ( $_GET['cat_id'] ) && $_GET['cat_id'] > 0 ) {
    settype ( $_GET['cat_id'], 'integer' );
} else {
    $_GET['cat_id'] = 'all';
}

$suchfeld = new template();
$suchfeld->setFile('0_downloads.tpl');
$suchfeld->load('SEARCH');

$suchfeld->tag('input_cat', '<input name="cat_id" value="'.$_GET['cat_id'].'" type="hidden">' );
$suchfeld->tag('keyword', $_GET['keyword'] );
$suchfeld->tag('all_url', url('download', array('cat_id' => $_GET['cat_id'])));

$suchfeld = $suchfeld->display ();


// Get Body Template
$template = new template();
$template->setFile('0_downloads.tpl');
$template->load('BODY');

$template->tag('navigation', $navi );
$template->tag('search', $suchfeld );
$template->tag('entries', $preview_list );
$template->tag('page_title', $page_titel );

$template = $template->display ();

//Seitentitel
$FD->setConfig('info', 'page_title', $page_titel);

$global_config_arr['dyn_description_page'] = 'Hier findest du alle Downloads aus dem Bereich ' . $page_titel . '.';
if ($filecount > 5)
	$global_config_arr['dyn_description_page'] .= " " . $filecount . ' Downloads warten auf Dich!';

?>
