<?php
////////////////////////
//// Hardcoded Vars ////
////////////////////////
$spam = 'wKAztWWB2Z'; //Anti-Spam Encryption-Code
$path = dirname(__FILE__) . '/'; //Dateipfad
define('DEBUG', TRUE);


// TODO: Pre-Import Hook
if (!DEBUG)
    error_reporting(0);

////////////////////////////////////////
//// Include important files & libs ////
////////////////////////////////////////
require_once(FS2_ROOT_PATH . 'config/db_connection.php');
require_once(FS2_ROOT_PATH . 'libs/class_GlobalData.php');
require_once(FS2_ROOT_PATH . 'libs/class_lang.php');
require_once(FS2_ROOT_PATH . 'libs/class_sql.php');
require_once(FS2_ROOT_PATH . 'includes/functions.php');

///////////////////////
//// DB Connection ////
///////////////////////

// TODO: Pre-Connection Hook

try {
    // Connect to DB-Server
    $sql = new sql($dbc['host'], $dbc['data'], $dbc['user'], $dbc['pass'], $dbc['pref']);

    // old connection
    $db = mysql_connect($dbc['host'], $dbc['user'], $dbc['pass']) or die(mysql_error());
    mysql_select_db($dbc['data'], $db) or die(mysql_error());
    $global_config_arr = array('pref' => $dbc['pref']);

    // Frogsystem Global Data Array
    $global_data = new GlobalData($sql);
    $FD =& $global_data; // Use shorthand $FD

    // Unset unused vars
    unset($spam, $dbc, $path);

//////////////////////////////
//// DB Connection failed ////
//////////////////////////////
} catch (Exception $e) {
	// log connection error
	error_log($e->getMessage(), 0);

    // Set header
    header(http_response_text(503), true, 503);
    header('Retry-After: '.(string)(60*15)); // 15 Minutes

    // Include lang-class
    require_once(FS2_ROOT_PATH . 'libs/class_lang.php');

    // get language
    $de = strpos($_SERVER['HTTP_ACCEPT_LANGUAGE'], 'de');
    $en = strpos($_SERVER['HTTP_ACCEPT_LANGUAGE'], 'en');

    if ($de !== false && $de < $en)
        $TEXT = new lang ('de_DE', 'frontend');
    else
        $TEXT = new lang ('en_US', 'frontend');

    // No-Connection-Page Template
    $template = '
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title>'.$TEXT->get("no_connection").'</title>
    </head>
    <body>
		<p>
			<b>'.$TEXT->get("no_connection_to_the_server").'</b>
        </p>
    </body>
</html>
    ';

    // Display No-Connection-Page
    echo $template;
    exit();
}

////////////////////////
//// Init Some Vars ////
////////////////////////

//TODO: First Init Hook

$_SESSION['user_level'] = !isset($_SESSION['user_level']) ? 'unknown' : $_SESSION['user_level'];
?>
