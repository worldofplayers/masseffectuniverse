<?php

//////////////////////////
//// Benutzer anlegen ////
//////////////////////////

if ($_POST[username] && $_POST[usermail])
{
    $_POST[username] = savesql($_POST[username]);
    $_POST[usermail] = savesql($_POST[usermail]);
    settype($_POST[regdate], "integer");

    // existiert dieser Username schon?
    $index = mysql_query("select user_name from fs_user where user_name = '$_POST[username]'", $db);
    $rows = mysql_num_rows($index);

    if ($rows == 0)
    {
        srand ((double)microtime()*1001000);
        $newpass = rand(10000000,99999999);
        $codedpass = md5($newpass);

        $_POST[showmail] = isset($_POST[showmail]) ? 1 : 0;

        $sqlquery = 'INSERT INTO fs_user (user_name, user_password, user_mail, reg_date, show_mail)
                     VALUES ("'.$_POST[username].'",
                             "'.$codedpass.'",
                             "'.$_POST[usermail].'",
                             "'.$_POST[regdate].'",
                             "'.$_POST[showmail].'");';
        mysql_query($sqlquery, $db);

        // Mail versenden
        $index = mysql_query("select template_code from fs_template where template_name = 'email_register'", $db);
        $template = stripslashes(mysql_result($index, 0, "template_code"));
        $template = str_replace("{username}", $_POST[username], $template); 
        $template = str_replace("{passwort}", $newpass, $template);

        $email_betreff = $phrases[registration] . " @ " . $global_config_arr[virtual_host];
        $header="From: ".$phrases[registration]." @ ".$global_config_arr[virtual_host]."\n"; 
        $header .= "Reply-To: ".$phrases[registration]." @ ".$global_config_arr[virtual_host]."\n"; 
        $header .= "Bcc: $_POST[usermail]\n"; 
        $header .= "X-Mailer: PHP/" . phpversion(). "\n"; 
        $header .= "X-Sender-IP: $REMOTE_ADDR\n"; 
        $header .= "Content-Type: text/html"; 

        mail($usermail, $email_betreff, $template, $header); 

        mysql_query("update fs_counter set user=user+1", $db);
        systext('User wurde hinzugefügt');
    }
    else
    {
        systext('Username existiert bereits');
    }
}

//////////////////////////
//// Benutzer Formular ///
//////////////////////////

else
{
    echo'
                    <form action="'.$PHP_SELF.'" method="post">
                        <input type="hidden" value="useradd" name="go">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <input type="hidden" value="'.time().'" name="regdate">
                        <table border="0" cellpadding="4" cellspacing="0" width="600">
                            <tr>
                                <td class="config" valign="top" width="50%">
                                    Name:<br>
                                    <font class="small">Name des Users</font>
                                </td>
                                <td class="config" width="50%" valign="top">
                                    <input class="text" size="30" name="username" maxlength="100">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    E-Mail:<br>
                                    <font class="small">E-Mail Adresse, an die das Passwort gesendet wird</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" size="30" name="usermail" maxlength="100">
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    Registrierdatum:<br>
                                    <font class="small">Anmeldedatum des Users</font>
                                </td>
                                <td align="center" class="config">
                                    '.date("d.m.Y", time()).'
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    Zeige Email:<br>
                                    <font class="small">Zeigt die Email Adresse öffentlich</font>
                                </td>
                                <td class="config">
                                    <input type="checkbox" name="showmail" value="1">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" align="center">
                                    <input type="submit" class="button" value="Hinzufügen">
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}
?>