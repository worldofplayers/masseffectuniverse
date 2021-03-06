<?php
function user_login ( $username, $password, $iscookie )
{
    global $FD;

    $index = $FD->sql()->conn()->prepare('SELECT * FROM '.$FD->config('pref')."user WHERE user_name = ?");
    $index->execute(array($username));
    $row = $index->fetch(PDO::FETCH_ASSOC);
    if ($row === false) {
        $FD->setConfig('goto', 'login');
        $FD->setConfig('env', 'goto', 'login');

        if ( $iscookie ) {
            delete_cookie ();
        }
        return 1;  // error code 1: user does not exist
    } else {
        $dbuserpass = $row['user_password'];
        $dbuserid = $row['user_id'];
        $username = $row['user_name'];
        $usersalt = $row['user_salt'];

        if ($iscookie===false) {
            $password = md5 ( $password.$usersalt );
        }

        if ($password == $dbuserpass) {
            $_SESSION['user_level'] = 'loggedin';
            $_SESSION['user_id'] = $dbuserid;
            $_SESSION['user_name'] = $username;
            return 0;  // Login akzeptiert
        }
        else {
            $FD->setConfig('goto', 'login');
            $FD->setConfig('env', 'goto', 'login');
            if ( $iscookie ) {
                delete_cookie ();
            }
            return 2;  // error code 2: wrong password
        }
    }
}


function set_cookie ( $username, $password )
{
    global $FD;

    $index = $FD->sql()->conn()->prepare('SELECT * FROM '.$FD->config('pref').'user WHERE user_name = ?');
    $index->execute(array($username));
    $row = $index->fetch(PDO::FETCH_ASSOC);
    if ($row === false)
    {
        return false;
    }
    else
    {

        $dbuserpass = $row['user_password'];
        //$dbuserid = $row['user_id'];
        $dbusersalt= $row['user_salt'];
        $password = md5 ( $password.$dbusersalt );

        if ($password == $dbuserpass)
        {
            $inhalt = $password . $username;
            setcookie ('login', $inhalt, time()+2592000, '/' );
            return true;  // login accepted
        }
        else
        {
            return false;
        }
    }
}


function delete_cookie ()
{
    setcookie ( 'login', '', time()-1000, '/' );
}


function logout_user()
{
    session_unset ();
    session_destroy ();
    $_SESSION = array();
    delete_cookie ();
}


function userlogin() {
    // Login in User
    if (!is_loggedin()) {
        global $FD;
        // From Post
        if (isset($_POST['login']) && $_POST['login'] == 1) {
            $FD->setConfig('login_state', user_login($_POST['username'], $_POST['userpassword'], FALSE));
        // From Cookie
        } elseif(isset($_COOKIE['login'])) {
            $userpassword = substr ($_COOKIE['login'], 0, 32);
            $username = substr($_COOKIE['login'], 32, strlen($_COOKIE['login']));
            $FD->setConfig('login_state', user_login($username, $userpassword, TRUE));
        }

        // stay online?
        if (isset($_POST['stayonline']) && $_POST['stayonline'] == 1 && $FD->config('login_state') == 0) {
            set_cookie ($_POST['username'], $_POST['userpassword']);
        }
    }
}
?>
