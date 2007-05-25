<?php

////////////////////////////////
//// Artikel aktualiesieren ////
////////////////////////////////

if ($_POST[title] && $_POST[url] && $_POST[preis])
{
    settype($_POST[editartikelid], 'integer');
    if (isset($_POST[delartikel]))
    {
        mysql_query("DELETE FROM fs_shop WHERE artikel_id = $_POST[editartikelid]", $db);
        unlink("../images/shop/".$_POST[editartikelid]."_s.jpg");
        unlink("../images/shop/".$_POST[editartikelid].".jpg");
        systext('Artikel wurde gel�scht');
    }
    else
    {
        $_POST[title] = savesql($_POST[title]);
        $_POST[url] = savesql($_POST[url]);
        $_POST[preis] = savesql($_POST[preis]);
        $_POST[text] = savesql($_POST[text]);
        $_POST[hot] = isset($_POST[hot]) ? 1 : 0;

        if (isset($_FILES[artikelimg]))
        {
            $valid_pic = upload_img($_FILES[artikelimg], "../images/shop/", $_POST[editartikelid], 2*1024*1024, 800, 600, 71, 100);
            systext(upload_img_notice($upload));
        }
        $update = "UPDATE fs_shop
                   SET artikel_name  = '$_POST[title]',
                       artikel_url   = '$_POST[url]',
                       artikel_text  = '$_POST[text]',
                       artikel_preis = '$_POST[preis]',
                       artikel_hot   = '$_POST[hot]'
                   WHERE artikel_id = $_POST[editartikelid]";
        mysql_query($update, $db);
        systext("Artikel wurde aktualisiert");
    }
}

////////////////////////////////
////// Artikel editieren ///////
////////////////////////////////

elseif ($_POST[artikelid])
{
    settype($_POST[artikelid], 'integer');
    $index = mysql_query("SELECT * FROM fs_shop WHERE artikel_id = $_POST[artikelid]", $db);
    $artikel_arr = mysql_fetch_assoc($index);
    $dbartikelhot = ($artikel_arr[artikel_hot] == 1) ? "checked" : "";

    echo'
                    <form action="'.$PHP_SELF.'" enctype="multipart/form-data" method="post">
                        <input type="hidden" value="shopedit" name="go">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <input type="hidden" value="'.$artikelid.'" name="editartikelid">
                        <table border="0" cellpadding="4" cellspacing="0" width="600">
                            <tr>
                                <td class="config" valign="top">
                                    Bild:<br>
                                    <font class="small">Aktuelles Artikelbild</font>
                                </td>
                                <td class="config" valign="top">
                                    <img src="../images/shop/'.$_POST[artikelid].'_s.jpg">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Neues Bild:<br>
                                    <font class="small">Nur ausf�llen, wenn das alte ersetzt werden soll</font>
                                </td>
                                <td class="config" valign="top">
                                    <input type="file" class="text" name="artikelimg" size="33">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Artikelname:<br>
                                    <font class="small">Name des Artikel. Kommt auch in den Hotlink</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" name="title" size="51" value="'.$artikel_arr[artikel_name].'" maxlength="100">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    URL:<br>
                                    <font class="small">Link zum Onlineshop</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" name="url" size="51" value="'.$artikel_arr[artikel_url].'" maxlength="255">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Artikelbeschreibung:<br>
                                    <font class="small">Kurze Artikelbeschreibung (optional)</font>
                                </td>
                                <td class="config" valign="top">
                                    <textarea class="text" name="text" rows="5" cols="51">'.$artikel_arr[artikel_text].'</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Preis:<br>
                                    <font class="small">Preis in $euro; (bsp 7,99)</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" name="preis" size="10" value="'.$artikel_arr[artikel_preis].'" maxlength="7">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Hotlink:<br>
                                    <font class="small">Hotlinks erscheinen rechts im Men�</font>
                                </td>
                                <td class="config" valign="top">
                                    <input type="checkbox" name="hot" value="1" '.$dbartikelhot.'>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    Artikel l�schen:
                                </td>
                                <td class="config">
                                    <input onClick="alert(this.value)" type="checkbox" name="delartikel" value="Sicher?">
                                </td>
                            </tr>
                            <tr>
                                <td align="center" colspan="2">
                                    <input class="button" type="submit" value="Absenden">
                                </td>
                            </tr>
                        </table>
                    </form>
        ';
}

////////////////////////////////
////// Artikel ausw�hlen ///////
////////////////////////////////

else
{
    echo'
                    <form action="'.$PHP_SELF.'" method="post">
                        <input type="hidden" value="shopedit" name="go">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <table border="0" cellpadding="2" cellspacing="0" width="600">
                            <tr>
                                <td class="config" width="20%">
                                    Bild
                                </td>
                                <td class="config" width="40%">
                                    Artikelname
                                </td>
                                <td class="config" width="20%">
                                    Preis
                                </td>
                                <td class="config" width="20%">
                                    bearbeiten
                                </td>
                            </tr>
    ';
    $index = mysql_query("SELECT artikel_id, artikel_name, artikel_preis
                          FROM fs_shop
                          ORDER BY artikel_name DESC", $db);
    while ($artikel_arr = mysql_fetch_assoc($index))
    {
        echo'
                            <tr>
                                <td class="config">
                                    <img src="../images/shop/'.$artikel_arr[artikel_id].'_s.jpg" width="35" height="50">
                                </td>
                                <td class="configthin">
                                    '.$artikel_arr[artikel_name].'
                                </td>
                                <td class="configthin">
                                    '.$artikel_arr[artikel_preis].'
                                </td>
                                <td class="config">
                                    <input type="radio" name="artikelid" value="'.$artikel_arr[artikel_id].'">
                                </td>
                            </tr>
        ';
    }
    echo'
                            <tr>
                                <td colspan="4">
                                    &nbsp;
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" align="center">
                                    <input class="button" type="submit" value="editieren">
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}
?>