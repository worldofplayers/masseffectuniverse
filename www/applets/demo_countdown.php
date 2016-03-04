<?php

    $endTime = mktime(0, 0, 0, 2, 14, 2012); //Stunde, Minute, Sekunde, Monat, Tag, Jahr;
    $timeNow = microtime(true);
    $diffTime = $endTime - $timeNow;
    $day = floor($diffTime / (24*3600)) + 1;
    
    if($day == 1)
        $day_text = " Tag ";
    else if($day <= 0)
        $release = "jetzt!";
    else
        $day_text = " Tagen ";
    
    if(empty($release)){
        $out = "in <br><span class=\"democountdown\">" . $day . $day_text;
        $img = "styles/lightfrog/download_button_big_sw.png";
    }
    else {
        $out =  "<br><span class=\"democountdown\"><a href=\"http://store.origin.com/store/eade/de_DE/html/originweb/play4free/pbPage.play-free-games-de_DE/\">jetzt</a>";
        $img = "styles/lightfrog/download_button_big.png";
    }
    
    $template = "<div style=\"\">
          <a id=\"demolink\" style=\"float: right;\" href=\"http://store.origin.com/store/eade/de_DE/html/originweb/play4free/pbPage.play-free-games-de_DE/\">
          <img style=\"margin: 0 5px 5px 5px;\" src=\"" .$img . "\">
          </a>
          <h3>ME3-Demo</h3>
          Ladet die Demo zu Mass Effect 3, dem Abschluss der epischen SciFi-Saga von BioWare, " .
          $out
          . "</span><br>herunter und gewinnt erste Einblicke in das am 8.3 erscheinende Spiel! 
          </div>";
    
?>
