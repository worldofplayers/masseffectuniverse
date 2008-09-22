<?php
///////////////////////////////////
//// PATH_SEPARATOR definieren ////
///////////////////////////////////
if ( ! defined( "PATH_SEPARATOR" ) ) {
  if ( strpos( $_ENV[ "OS" ], "Win" ) !== false )
    define( "PATH_SEPARATOR", ";" );
  else define( "PATH_SEPARATOR", ":" );
}

// Start Session
session_start();

// script path-length
$delete_last = strlen ( "/admin/admin_articles_prev.php" ) * -1;
// Set Include Path
set_include_path ( substr ( __FILE__, 0, $delete_last ) );

// Include Files
require("login.inc.php");
require("includes/functions.php");
require("includes/cookielogin.php");
require("includes/imagefunctions.php");
require("includes/indexfunctions.php");
require("phrases/phrases_".$global_config_arr['language'].".php");

// Constructor Calls
set_design ();
copyright ();

// Reload Page
if ( !$_POST['article_text'] && !$_POST['sended'] )
{
	// Reload Page Template
 $template = '
<html>
	<head>
		<title>Frogsystem 2 - Artikelvorschau</title>
		<script>
	        function loaddata()
	        {
	            document.getElementById(\'article_title\').value = opener.document.getElementById(\'article_title\').value;
	            document.getElementById(\'article_user\').value = opener.document.getElementById(\'userid\').value;
	            document.getElementById(\'article_user_name\').value = opener.document.getElementById(\'username\').value;

	            document.getElementById(\'d\').value = opener.document.getElementById(\'d\').value;
	            document.getElementById(\'m\').value = opener.document.getElementById(\'m\').value;
	            document.getElementById(\'y\').value = opener.document.getElementById(\'y\').value;

				if ( opener.document.getElementById(\'article_html\').checked == true ) {
				    document.getElementById(\'article_html\').value = 1;
				} else {
				    document.getElementById(\'article_html\').value = 0;
				}
				if ( opener.document.getElementById(\'article_fscode\').checked == true ) {
				    document.getElementById(\'article_fscode\').value = 1;
				} else {
				    document.getElementById(\'article_fscode\').value = 0;
				}
				if ( opener.document.getElementById(\'article_para\').checked == true ) {
				    document.getElementById(\'article_para\').value = 1;
				} else {
				    document.getElementById(\'article_para\').value = 0;
				}
				
	            document.getElementById(\'article_text\').value = opener.document.getElementById(\'article_text\').value;

	            document.getElementById(\'form\').submit();
	        }
		</script>
	</head>
	<body onLoad="loaddata()">
		<form action="'.$global_config_arr['virtualhost'].'admin/admin_articles_prev.php" method="post" id="form">
			<input type="hidden" name="sended" id="sended" value="1">
			<input type="hidden" name="article_title" id="article_title" value="">
			<input type="hidden" name="article_user" id="article_user" value="">
			<input type="hidden" name="article_user_name" id="article_user_name" value="">
			<input type="hidden" name="d" id="d" value="">
			<input type="hidden" name="m" id="m" value="">
			<input type="hidden" name="y" id="y" value="">
			<input type="hidden" name="article_html" id="article_html" value="">
			<input type="hidden" name="article_fscode" id="article_fscode" value="">
			<input type="hidden" name="article_para" id="article_para" value="">
			<input type="hidden" name="article_text" id="article_text" value="">
		</form>
	</body>
</html>';

	// "Display" Reload Page
	echo $template;
}

// Preview Page
else
{
	// Load Data from $_POST
	$article_arr['article_title'] = stripslashes ( $_POST['article_title'] );

	// Create Article-Date
	if (
			( $_POST['d'] && $_POST['d'] != "" && $_POST['d'] > 0 ) &&
			( $_POST['m'] && $_POST['m'] != "" && $_POST['m'] > 0 ) &&
			( $_POST['y'] && $_POST['y'] != "" && $_POST['y'] > 0 ) &&
			( isset ( $_POST['d'] ) && isset ( $_POST['m'] ) && isset ( $_POST['y'] ) )
		)
    {
		settype ( $_POST['d'], "integer" );
		settype ( $_POST['m'], "integer" );
		settype ( $_POST['y'], "integer" );
		$article_arr['article_date'] = mktime ( 0, 0, 0, $_POST['m'], $_POST['d'], $_POST['y'] );
	} else {
	    $article_arr['article_date'] = 0;
	}
	if ( $article_arr['article_date'] != 0 ) {
	    $article_arr['article_date_formated'] = date ( $global_config_arr['date'], $article_arr['article_date'] );
	} else {
	    $article_arr['article_date_formated'] = "";
	}

	// Format Article-Text
	settype ( $_POST['article_html'], "integer" );
	settype ( $_POST['article_fscode'], "integer" );
	settype ( $_POST['article_para'], "integer" );
	$article_arr['article_text'] = fscode ( $_POST['article_text'], $_POST['article_fscode'], $_POST['article_html'], $_POST['article_para'] );

	// Format User
	$article_arr['article_user_name'] = killhtml ( $_POST['article_user_name'] );
	$article_arr['article_user'] = $_POST['article_user'];
	settype ( $article_arr['article_user'], "integer" );

	// Create User Template
	if ( $article_arr['article_user_name'] != "" && $article_arr['article_user'] > 0 ) {
		$article_arr['user_link'] = $global_config_arr['virtualhost'].'?go=profil&userid='.$article_arr['article_user'];
		$article_arr['user_template'] = get_template ( "artikel_autor" );
	    $article_arr['user_template'] = str_replace ( "{profile_url}", $article_arr['user_link'], $article_arr['user_template'] );
		$article_arr['user_template'] = str_replace ( "{user_name}", $article_arr['article_user_name'], $article_arr['user_template'] );
		$article_arr['user_template'] = str_replace ( "{user_id}", $article_arr['article_user'], $article_arr['user_template'] );
	} else {
    	$article_arr['article_user_name'] = "";
    	$article_arr['article_user'] = "";
    	$article_arr['user_link'] = "";
    	$article_arr['user_template'] = "";
	}

	// Create Template
	$article_arr['template'] = get_template ( "artikel_body" );
	$article_arr['template'] = str_replace ( "{title}", $article_arr['article_title'], $article_arr['template'] );
	$article_arr['template'] = str_replace ( "{date}", $article_arr['article_date_formated'], $article_arr['template'] );
	$article_arr['template'] = str_replace ( "{text}", $article_arr['article_text'], $article_arr['template'] );
	$article_arr['template'] = str_replace ( "{user_name}", $article_arr['article_user_name'], $article_arr['template'] );
	$article_arr['template'] = str_replace ( "{user_id}", $article_arr['article_user'], $article_arr['template'] );
	$article_arr['template'] = str_replace ( "{author_template}", $article_arr['user_template'], $article_arr['template'] );
	$template_preview =  $article_arr['template'];
	
	// Preview Page Template
    $global_config_arr['title'] = "Frogsystem 2 - Artikelvorschau: " . $global_config_arr['title'];
	$template_index = get_template ( "indexphp" );
	$template_index = str_replace ( "{main_menu}", get_mainmenu ( "../" ), $template_index );
	$template_index = str_replace ( "{content}", $template_preview, $template_index );
	$template_index = str_replace ( "{copyright}", get_copyright (), $template_index );
	$template_index = replace_resources ( $template_index, "../" );
	$template_index = veraltet_includes ( $template_index ); // wird sp�ter zu seitenvariablen funktion, mit virtualhost umwandlung
	$template_index = killbraces ( $template_index );
	$template = get_maintemplate ( "../" );
	$template = str_replace ( "{body}", $template_index, $template);

	// Display Preview Page
	echo $template;

}
mysql_close($db);
?>