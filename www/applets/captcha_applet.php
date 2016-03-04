<?php
define ("START", time());

$template =  "<tr><td></td><td><input type=\"hidden\" name=\"dudu\" value=\"" . strrev(time()) . "\"></td></tr>";
$template .= "<tr class=\"email\"><td class=\"small\">Deine Email-Adresse nicht angeben!</td><td><input type=\"text\" name=\"email_form\"></td></tr>";
$template .= "<tr style=\"display: none;\"><td class=\"small\">Bist du ein Bot?</td><td class=\"small\"><input type=\"checkbox\" name=\"bot\">&nbsp;<span class=\"bot\">Ja, bin ich<span></td></tr>";
?>
