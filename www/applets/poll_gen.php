<?php
$lang = $_POST['language'];

if($lang == "german"){
    $lang = "Deutsch";
    $send = "Senden";
    $fraguant = array("q1" => array("f" => "Auf welcher Plattform spielst du Mass Effect 3?","a1" => "PC", "a2" => "Xbox 360", "a3" => "PS3"),
                    "q2" => array("f" => "Welche Version von Mass Effect 3 hast du?","a1" => "Standard", "a2" => "Collector’s Edition", "a3" => "Standard (digital)", "a4" => "Collector’s Edition (digital)"),
                    "q3" => array("f" => "Spielst du einen männlichen oder weiblichen Shepard?","a1" => "weiblich", "a2" => "männlich"),
                    "q4" => array("f" => "Hast du einen Spielstand importiert?","a1" => "Ja", "a2" => "Nein"),
                    "q5" => array("f" => "Mit welcher Klasse hast du Mass Effect 3 (das erste Mal) gespielt?","a1" => "Soldat", "a2" => "Frontkämpfer", "a3" => "Infiltrator", "a4" => "Wächter", "a5" => "Experte", "a6" => "Techniker"),
                    "q6" => array("f" => "Wenn du einen Spielstand importiert hast, hast du dieselbe Klasse weiter gespielt?","a1" => "Ja", "a2" => "Nein"),
                    "q7" => array("f" => "Spielst du mit dem Standard-Aussehen?","a1" => "Ja", "a2" => "Nein"),
                    "q8" => array("f" => "Wenn du einen Spielstand importiert hast, hast du dein Gesicht verändert?","a1" => "Ja", "a2" => "Nein"),
                    "q9" => array("f" => "Welche zwei Charaktere haben dich am häufigsten auf den Missionen begleitet?", "a0" => "[Bitte wählen]" ,"a1" => "James", "a2" => "Liara", "a3" => "Kaidan", "a4" => "Ashley", "a5" => "Garrus", "a6" => "EDI", "a7" => "Javik", "a8" => "Tali"),
                    "q10" => array("f" => "Spielst du Paragon oder Renegade?","a1" => "Paragon", "a2" => "Renegade", "a3" => "Ausgewogen"),
                    "q11" => array("f" => "Mit wem bist du eine Romanze eigegangen?", "a0" => "[Bitte wählen]" ,"a1" => "Garrus", "a2" => "Kaidan", "a3" => "Liara", "a4" => "Samantha", "a5" => "Diana", "a6" => "Ashley", "a7" => "Tali", "a8" => "Miranda", "a9" => "Cortez", "a10" => "Jack", "a11" => "Thane", "a12" => "keinem"),
                    "q12" => array("f" => "Hast du die Genophage geheilt?","a1" => "Ja", "a2" => "Nein"),
                    "q13" => array("f" => "Wie hast du dich im Geth-Quarianer Konflikt entscheiden?","a1" => "Geth unterstützt", "a2" => "Quarianer unterstützt", "a3" => "Beide zusamengeführt"),
                    "q14" => array("f" => "Hast du den DLC „Aus der Asche“?","a1" => "Ja", "a2" => "Nein"),
                    "q15" => array("f" => "Liest oder hörst du die Kodexeinträge im Spiel?","a1" => "Nein, niemals", "a2" => "Ab und zu, wenn ich Infos brauche", "a3" => "Meistens", "a4" => "Ja, immer"),
                    "q16" => array("f" => "Liest du Planetenbeschreibungen?","a1" => "Nein, niemals", "a2" => "Ab und zu, überfliege ich sie", "a3" => "Meistens", "a4" => "Ja, immer"),
                    "q17" => array("f" => "Wie häufig hast du Mass Effect 3 durchgespielt?","a1" => "1 Mal", "a2" => "2-3 Mal", "a3" => "3-6 Mal", "a4" => "Mehr als 7 Mal"),
                    "q18" => array("f" => "Für welches Ende hast du dich entschieden?","a1" => "Zerstörung der Reaper (rot)", "a2" => "Kontrolle über Reaper (blau)", "a3" => "Synthese (grün)"),
                    "q19" => array("f" => "Welches Ende ist in deinen Augen das „positivste“ für die Galaxis?","a1" => "Zerstörung der Reaper (rot)", "a2" => "Kontrolle über Reaper (blau)", "a3" => "Synthese (grün)"),
                    "q20" => array("f" => "Was war deine erste Reaktion auf das Ende?","a1" => "Wow, gutes Ende, gefällt mir sehr", "a2" => "Hm, ganz in Ordnung", "a3" => "Eher schlecht. Habe mehr erwartet", "a4" => "Schrecklich, Logiklöcher, kaum Einfluss"),
                    "q21" => array("f" => "Hältst du die Indoktrinationstheorie für schlüssig?","a1" => "Ja, genau meine Meinung", "a2" => "Nein, zu vieles spricht dagegen", "a3" => "Unschlüssig/hat auch Logiklöcher"),
                    "q22" => array("f" => "Was glaubst du ist das Space-Kind?","a1" => "Schöpfer d. Reaper/Wächter d. Zyklus", "a2" => "Ein Reaper", "a3" => "Anderes höheres Wesen", "a4" => "Nichts dergleichen"),
                    "q23" => array("f" => "Hättest du dir ein klassisches Happy End gewünscht?","a1" => "Ja", "a2" => "Nein", "a3" => "Zumindest als Möglichkeit"),
                    "q24" => array("f" => "Welche Note gibst du ME3 bis 10 min vor Ende?","a1" => "10 (perfekt)", "a2" => "5 (ok)", "a3" => "0 (mies)"),
                    "q25" => array("f" => "Welche Note gibst du dem Ende von Mass Effect 3?","a1" => "10 (perfekt)", "a2" => "5 (ok)", "a3" => "0 (mies)"),
                    "q26" => array("f" => "Wie sieht deine Gesamtnote für Mass Effect 3 aus?","a1" => "10 (perfekt)", "a2" => "5 (ok)", "a3" => "0 (mies)"),
                    "q27" => array("f" => "Glaubst du, dass der kommende DLC die Enden logisch aufschlüsseln kann?","a1" => "Ich glaube schon", "a2" => "Ich denke eher nicht", "a3" => "Ich bin skeptisch, hoffe aber"),
                    "q28" => array("f" => "Lädst du Gamefeedback hoch?","a1" => "Ja", "a2" => "Nein", "a3" => "Ich kenne diese Funktion nicht"),
                    "q29" => array("f" => "Würdest du Geld für weitere DLCs ausgeben für ME3?","a1" => "Ja", "a2" => "Ja, aber nur für Story-DLCs mit Umfang", "a3" => "Nein, eher nicht", "a4" => "Nein, Bioware sieht kein Geld mehr von mir"),
                    "q30" => array("f" => "Hast du im Multiplayer bereits Punkte (echtes Geld) ausgegeben?","a1" => "Ja, mehr als 800 Punkte", "a2" => "Ja, weniger als 800 Punkte", "a3" => "Nein"),
                    "q31" => array("f" => "Welche Klasse nutzt du bevorzugt im Multiplayer?","a1" => "Soldat", "a2" => "Frontkämpfer", "a3" => "Infiltrator", "a4" => "Wächter", "a5" => "Experte", "a6" => "Techniker"),
                    "q32" => array("f" => "Wie häufig startest du den Multiplayer von ME3?","a1" => "Täglich", "a2" => "Mehrmals wöchentlich", "a3" => "Einmal pro Woche", "a4" => "Seltener", "a5" => "Nie"),
                    "q33" => array("f" => "Wie viel Zeit verbringst du in etwa im MP pro Start?","a1" => "Weniger als eine halbe Stunde", "a2" => "Etwa eine Stunde", "a3" => "Mehr als eine Stunde"),
                    "q34" => array("f" => "Was wünscht du dir für den Multiplayer?","a1" => "Mehr Klassen", "a2" => "Mehr Spezies", "a3" => "Mehr Maps", "a4" => "Mehr Spielmodi", "a5" => "Nichts, bin zufrieden"),
                    "q35" => array("f" => "Welche Note gibst du dem Multiplayer?","a1" => "10 (perfekt)", "a2" => "5 (ok)", "a3" => "0 (mies)"),
                    "q36" => array("f" => "Welche Note gibst du dem kostenlosen MP-DLC (Resurgence)?","a1" => "10 (perfekt)", "a2" => "5 (ok)", "a3" => "0 (mies)"),
                    "q37" => array("f" => "Was würdest du BioWare in<input readonly type=\"text\" name=\"countdown\" size=\"2\" value=\"140\" class=\"count_txt\">Zeichen mitteilen wollen? (optional)"),
                    "q38" => array("f" => "Was war der für dich emotionalste Moment?", "a1" => "Tod von Ash/Kaidan", "a2" => "Mirandas Tod", "a3" => "Aufbruch zur Erde", "a4" => "Flucht von der Erde", "a5" => "Tod von Thane", "a6" => "Rückeroberung Rannochs", "a7" => "Heilung der Genophage",
                                   "a8" => "Mordins Tod", "a9" => "Fall von Thessia", "a10" => "Kai Lengs Tod", "a11" => "Talis Tod", "a12" => "Legions Tod", "a13" => "Romanze", "a14" => "Tod von Tarquin Victus", "a15" => "Szene mit Garrus (Dosenschießen)", "a16" => "Verabschiedungen in London",
                                   "a17" => "Das Ende", "a18" => "Evas Tod", "a19" => "Samaras Selbstmord", "a20" => "Grunts Scheintod", "a21" => "Reaper-Tod auf Rannoch", "a22" => "Anderer Moment")
    );
}

else if($lang == "english"){
    $lang = "English";
    $send = "submit";
    $fraguant = array("q1" => array("f" => "On which platform do you play ME3?","a1" => "PC", "a2" => "Xbox 360", "a3" => "PS3"),
                    "q2" => array("f" => "Which version of ME3 did you buy?","a1" => "Standard", "a2" => "Collector’s Edition", "a3" => "Standard (digital)", "a4" => "Collector’s Edition (digital)"),
                    "q3" => array("f" => "Do you play as male or as female Shepard?","a1" => "female", "a2" => "male"),
                    "q4" => array("f" => "Did you import a savegame?","a1" => "Yes", "a2" => "No"),
                    "q5" => array("f" => "Which class did you choose for the first time in Mass Effect 3?","a1" => "Soldier", "a2" => "Vanguard", "a3" => "Infiltrator", "a4" => "Sentinel", "a5" => "Adept", "a6" => "Engineer"),
                    "q6" => array("f" => "Did you play the same class if you imported a saved game from ME2?","a1" => "Yes", "a2" => "No"),
                    "q7" => array("f" => "Do you play with the default Shepard face? ","a1" => "Yes", "a2" => "No"),
                    "q8" => array("f" => "If you imported a saved game, did you change Shepard's face? ","a1" => "Yes", "a2" => "No"),
                    "q9" => array("f" => "Which squadmates did you take with you the most of your missions?", "a0" => "[Please choose]" ,"a1" => "James", "a2" => "Liara", "a3" => "Kaidan", "a4" => "Ashley", "a5" => "Garrus", "a6" => "EDI", "a7" => "Javik", "a8" => "Tali"),
                    "q10" => array("f" => "Do you play as a paragon or renegade Shepard? ","a1" => "paragon", "a2" => "renegade", "a3" => "Balanced"),
                    "q11" => array("f" => "Who was your love interest?", "a0" => "[Please choose]" ,"a1" => "Garrus", "a2" => "Kaidan", "a3" => "Liara", "a4" => "Samantha", "a5" => "Diana", "a6" => "Ashley", "a7" => "Tali", "a8" => "Miranda", "a9" => "Cortez", "a10" => "Jack", "a11" => "Thane", "a12" => "none"),
                    "q12" => array("f" => "Did you cure the Genophage?","a1" => "Yes", "a2" => "No"),
                    "q13" => array("f" => "What was your choice in the Geth and Quarian conflict? ","a1" => "supported Geth", "a2" => "supported Quarians", "a3" => "supported both"),
                    "q14" => array("f" => "Do you have the DLC 'From Ashes'?","a1" => "Yes", "a2" => "No"),
                    "q15" => array("f" => "Do you listen to or read the Codex entries? ","a1" => "No, never", "a2" => "Sometimes, if i need information", "a3" => "Often", "a4" => "Every single one"),
                    "q16" => array("f" => "Do you read the informations about the different planets?","a1" => "No", "a2" => "Sometimes when scanning them", "a3" => "Often", "a4" => "Every single one"),
                    "q17" => array("f" => "How many times did you do a whole ME3 playthrough?","a1" => "1 time", "a2" => "2-3 times", "a3" => "4-6 times", "a4" => "more than 7 times"),
                    "q18" => array("f" => "What was your decision at the end?","a1" => "Destruction of the reapers (red)", "a2" => "Controlling the reapers (blue)", "a3" => "Synthesis (green)"),
                    "q19" => array("f" => "What's the best ending in our oppinion?","a1" => "Destruction of the reapers (red)", "a2" => "Controlling the reapers (blue)", "a3" => "Synthesis (green)"),
                    "q20" => array("f" => "What was your reaction upon experiencing the ME3 endings?","a1" => "Wow, great ending, i like it!", "a2" => "Hm, not best, but it's okay.", "a3" => "Is that all? I've been expecting more than that!", "a4" => "Terrible, many logical mistakes, it's all the same."),
                    "q21" => array("f" => "What do you think about the indoctrination-theory","a1" => "Great, i agree with it", "a2" => "No, to many not matching facts", "a3" => "Unrealistic, to many logical mistakes."),
                    "q22" => array("f" => "In your opinion, what could the 'space child' be? ","a1" => "Creator of the reapers/guardian of the cycle", "a2" => "a reaper", "a3" => "a celestial creature", "a4" => "nothing of the sort"),
                    "q23" => array("f" => "Would you like a typical happy ending?","a1" => "Yes", "a2" => "No", "a3" => "It should be one possible decision"),
                    "q24" => array("f" => "What score would you give Mass Effect 3 up to 10 minutes before the ending?","a1" => "10 (perfect)", "a2" => "5 (okay)", "a3" => "0 (terrible)"),
                    "q25" => array("f" => "What score would you give to the ending of Mass Effect 3?","a1" => "10 (perfect)", "a2" => "5 (okay)", "a3" => "0 (terrible)"),
                    "q26" => array("f" => "What overall score would you give for the entire Mass Effect 3 game?","a1" => "10 (perfect)", "a2" => "5 (okay)", "a3" => "0 (terrible)"),
                    "q27" => array("f" => "Do you think that the upcoming Extended Cut DLC can fill all the logical gaps?","a1" => "I think so, yes", "a2" => "I don't think so.", "a3" => "I'm skeptical, but it could be"),
                    "q28" => array("f" => "Do you have the option to upload game feedback enabled?","a1" => "Yes", "a2" => "No", "a3" => "What's that?!"),
                    "q29" => array("f" => "Would you spend more money on more ME3 DLCs","a1" => "Yes", "a2" => "Yes, but only for story related DLCs.", "a3" => "No, not really", "a4" => "No, I've spend enough money on ME3!"),
                    "q30" => array("f" => "Have you ever spent real money on multiplayer?","a1" => "Yes, more than 800 Points", "a2" => "Yes, but less than 800 Points", "a3" => "No"),
                    "q31" => array("f" => "What class do you prefer in multiplayer?","a1" => "Soldier", "a2" => "Vanguard", "a3" => "Infiltrator", "a4" => "Sentinel", "a5" => "Adept", "a6" => "Engineer"),
                    "q32" => array("f" => "How often do you play the multiplayer?","a1" => "Every day", "a2" => "More than 1 day in a week", "a3" => "Weekly", "a4" => "Not really often", "a5" => "Never"),
                    "q33" => array("f" => "How long do you play multiplayer per gaming session?","a1" => "Less than half an hour", "a2" => "One hour", "a3" => "More than one hour"),
                    "q34" => array("f" => "What would you like to see for multiplayer in the future?","a1" => "More classes", "a2" => "More alien races", "a3" => "More maps", "a4" => "More game modes", "a5" => "Nothing, it's perfect"),
                    "q35" => array("f" => "What score would you give to multiplayer?","a1" => "10 (perfect)", "a2" => "5 (okay)", "a3" => "0 (terrible)"),
                    "q36" => array("f" => "What score would you give to the free Multiplayer DLC (Resurgence)?","a1" => "10 (perfect)", "a2" => "5 (okay)", "a3" => "0 (terrible)"),
                    "q37" => array("f" => "What would you say to Bioware in<input readonly type=\"text\" name=\"countdown\" size=\"2\" value=\"140\" class=\"count_txt\">characters? (optional)"),
                    "q38" => array("f" => "What was the most emotional moment for you?", "a1" => "Ash's/Kaidan's death", "a2" => "Miranda's death", "a3" => "departure to earth", "a4" => "escape from earth", "a5" => "Thane's death", "a6" => "recapture of Rannoch", "a7" => "cure of Genophage",
                                   "a8" => "Mordin's death", "a9" => "downfall of Thessia", "a10" => "Kai Leng's death", "a11" => "Tali's death", "a12" => "Legion's death", "a13" => "romance", "a14" => "death of Tarquin Victus", "a15" => "Shep and Garrus shooting cans", "a16" => "farewells in London",
                                   "a17" => "the ending", "a18" => "Eva's death", "a19" => "Samara's suicide", "a20" => "Grunt's 'resurrection'", "a21" => "Reaper-death on Rannoch", "a22" => "other moment")
    );
}
else
    $error_string = "An error occurred! Please try again!<br>If the problem remains please write an email to noni[at]masseffect-universe.de";

if(isset($fraguant)){
$css = <<<DOC
<style type="text/css">
#poll_form{
    background-color: white;
    height: 720px;
    width: 1080px;
    font-size: 90%;
    color: black;
    padding: 10px;
    margin: auto;
}

#poll_error {display: none;background: red;color: #FFF;text-align:center;}

#questions_l{width: 500px; height: auto; float: left; margin-right: 5px;}
#questions_r{width: 500px; height: auto; float: left;}

td{height:auto; margin: 2px;}
select{position:relative; top:-4px;}

.label_q{display: inline-block; width: 240px;}
.count_txt{display:inline;color:red;border-color:transparent;font-size: 90%;}
#q37{max-height:50px;max-width:230px;}

</style>
DOC;
$out = <<<DOC
<form id="poll_form" method="post" action="">
    <p id="poll_error">Bitte alle Felder ausfüllen! // All fields are required!</p>
    <table id="questions_l">
        <tr>
            <td class="label_q">{$fraguant['q1']['f']}</td>
            <td class="answers">
                <input type="radio"  name="q1" value="pc" checked="checked"> {$fraguant['q1']['a1']}
                &nbsp;
                <input type="radio"  name="q1" value="xbox"> {$fraguant['q1']['a2']}
                &nbsp;
                <input type="radio"  name="q1" value="ps"> {$fraguant['q1']['a3']}
            </td>
        </tr>
        <tr>
            <td class="label_q">{$fraguant['q2']['f']}</td>
            <td class="answers">
                <select name="q2">
                    <option selected="selected" value="stand">{$fraguant['q2']['a1']}</option><option value="collect">{$fraguant['q2']['a2']}</option>
                    <option value="stand_d">{$fraguant['q2']['a3']}</option><option value="collect_d">{$fraguant['q2']['a4']}</option>
                </select>
            </td>
        </tr>
        <tr>
            <td class="label_q">{$fraguant['q3']['f']}</td>
            <td id="q3" class="answers">
                <input type="radio"  name="q3" value="female" checked="checked"> {$fraguant['q3']['a1']}
                &nbsp;
                <input type="radio"  name="q3" value="male"> {$fraguant['q3']['a2']}
            </td>
        </tr>
        <tr>
            <td class="label_q">{$fraguant['q4']['f']}</td>
            <td id="q4" class="answers">
                <input type="radio"  name="q4" value="yes" checked="checked"> {$fraguant['q4']['a1']}
                &nbsp;
                <input type="radio"  name="q4" value="no"> {$fraguant['q4']['a2']}
            </td>
        </tr>
        <tr>
            <td class="label_q">{$fraguant['q5']['f']}</td>
            <td class="answers">
                <select name="q5">
                    <option selected="selected" value="soldier">{$fraguant['q5']['a1']}</option><option value="vanguard">{$fraguant['q5']['a2']}</option>
                    <option value="infiltrator">{$fraguant['q5']['a3']}</option><option value="sentinel">{$fraguant['q5']['a4']}</option>
                    <option value="adept">{$fraguant['q5']['a5']}</option><option value="ingenieur">{$fraguant['q5']['a6']}</option>    
                </select>
            </td>
        </tr>
        <tr>
            <td class="label_q">{$fraguant['q6']['f']}</td>
            <td class="answers">
                <input type="radio"  name="q6" value="yes" checked="checked"> {$fraguant['q6']['a1']}
                &nbsp;
                <input type="radio"  name="q6" value="no"> {$fraguant['q6']['a2']}
            </td>
        </tr>
        <tr>
            <td class="label_q">{$fraguant['q7']['f']}</td>
            <td class="answers">
                <input type="radio"  name="q7" value="yes" checked="checked"> {$fraguant['q7']['a1']}
                &nbsp;
                <input type="radio"  name="q7" value="no"> {$fraguant['q7']['a2']}
            </td>
        </tr>
        <tr>
            <td class="label_q">{$fraguant['q8']['f']}</td>
            <td class="answers">
                <input type="radio"  name="q8" value="yes" checked="checked"> {$fraguant['q8']['a1']}
                &nbsp;
                <input type="radio"  name="q8" value="no"> {$fraguant['q8']['a2']}
            </td>
        </tr>
        <tr>
            <td class="label_q">{$fraguant['q9']['f']}</td>
            <td id="q9" class="answers">
                <select name="q9_1" id="q9_1"><option>{$fraguant['q9']['a0']}</option>
                    <option value="james">{$fraguant['q9']['a1']}</option><option value="liara">{$fraguant['q9']['a2']}</option>
                    <option value="kaidan">{$fraguant['q9']['a3']}</option><option value="ash">{$fraguant['q9']['a4']}</option>
                    <option value="garrus">{$fraguant['q9']['a5']}</option><option value="edi">{$fraguant['q9']['a6']}</option> 
                    <option value="javik">{$fraguant['q9']['a7']}</option><option value="tali">{$fraguant['q9']['a8']}</option>
                </select>
                <select name="q9_2" id="q9_2"><option>{$fraguant['q9']['a0']}</option>
                    <option value="james">{$fraguant['q9']['a1']}</option><option value="liara">{$fraguant['q9']['a2']}</option>
                    <option value="kaidan">{$fraguant['q9']['a3']}</option><option value="ash">{$fraguant['q9']['a4']}</option>
                    <option value="garrus">{$fraguant['q9']['a5']}</option><option value="edi">{$fraguant['q9']['a6']}</option> 
                    <option value="javik">{$fraguant['q9']['a7']}</option><option value="tali">{$fraguant['q9']['a8']}</option>
                </select>
            </td>
        </tr>
        <tr>
            <td class="label_q">{$fraguant['q10']['f']}</td>
            <td class="answers">
                <select name="q10">
                    <option selected="selected" value="para">{$fraguant['q10']['a1']}</option><option value="rene">{$fraguant['q10']['a2']}</option>
                    <option value="balan">{$fraguant['q10']['a3']}</option>
                </select>
            </td>
        </tr>
        <tr>
            <td class="label_q">{$fraguant['q11']['f']}</td>
            <td class="answers">
                <select name="q11" id="q11"><option>{$fraguant['q11']['a0']}</option>
                    <option value="garrus">{$fraguant['q11']['a1']}</option><option value="kaidan">{$fraguant['q11']['a2']}</option>
                    <option value="liara">{$fraguant['q11']['a3']}</option><option value="samantha">{$fraguant['q11']['a4']}</option>
                    <option value="diana">{$fraguant['q11']['a5']}</option><option value="ash">{$fraguant['q11']['a6']}</option>
                    <option value="tali">{$fraguant['q11']['a7']}</option><option value="miranda">{$fraguant['q11']['a8']}</option>
                    <option value="cortez">{$fraguant['q11']['a9']}</option><option value="jack">{$fraguant['q11']['a10']}</option>
                    <option value="thane">{$fraguant['q11']['a11']}</option><option value="none">{$fraguant['q11']['a12']}</option>
                </select>
            </td>
        </tr>
        <tr>
            <td class="label_q">{$fraguant['q12']['f']}</td>
            <td id="q12" class="answers">
                <input type="radio"  name="q12" value="yes" checked="checked"> {$fraguant['q12']['a1']}
                &nbsp;
                <input type="radio"  name="q12" value="no"> {$fraguant['q12']['a2']}
            </td>
        </tr>
        <tr>
            <td class="label_q">{$fraguant['q13']['f']}</td>
            <td class="answers">
                <select name="q13">
                    <option selected="selected" value="geth">{$fraguant['q13']['a1']}</option><option value="quari">{$fraguant['q13']['a2']}</option>
                    <option value="both">{$fraguant['q13']['a3']}</option>
                </select>
            </td>
        </tr>
        <tr>
            <td class="label_q">{$fraguant['q14']['f']}</td>
            <td class="answers">
                <input type="radio"  name="q14" value="yes" checked="checked">{$fraguant['q14']['a1']}
                &nbsp;
                <input type="radio"  name="q14" value="no">{$fraguant['q14']['a2']}
            </td>
        </tr>
        <tr>
            <td class="label_q">{$fraguant['q15']['f']}</td>
            <td class="answers">
                <select name="q15">
                    <option selected="selected" value="no">{$fraguant['q15']['a1']}</option><option value="nat">{$fraguant['q15']['a2']}</option>
                    <option value="mostly">{$fraguant['q15']['a3']}</option><option value="yes">{$fraguant['q15']['a4']}</option>
                </select>
            </td>
        </tr>
        <tr>
            <td class="label_q">{$fraguant['q16']['f']}</td>
            <td class="answers">
                <select name="q16">
                    <option selected="selected" value="no">{$fraguant['q16']['a1']}</option><option value="nat">{$fraguant['q16']['a2']}</option>
                    <option value="mostly">{$fraguant['q16']['a3']}</option><option value="yes">{$fraguant['q16']['a4']}</option>
                </select>
            </td>
        </tr>
        <tr>
            <td class="label_q">{$fraguant['q17']['f']}</td>
            <td class="answers">
                <select name="q17">
                    <option selected="selected" value="once">{$fraguant['q17']['a1']}</option><option value="three">{$fraguant['q17']['a2']}</option>
                    <option value="six">{$fraguant['q17']['a3']}</option><option value="moreseven">{$fraguant['q17']['a4']}</option>
                </select>
            </td>
        </tr>
        <tr>
            <td class="label_q">{$fraguant['q38']['f']}</td>
            <td class="answers">
                <select name="q38">
                    <option selected="selected" value="ashkaidan">{$fraguant['q38']['a1']}</option><option value="miranda">{$fraguant['q38']['a2']}</option>
                    <option value="departure">{$fraguant['q38']['a3']}</option><option value="escape">{$fraguant['q38']['a4']}</option>
                    <option value="thane">{$fraguant['q38']['a5']}</option><option value="recapture">{$fraguant['q38']['a6']}</option>
                    <option value="genophage">{$fraguant['q38']['a7']}</option><option value="mordin">{$fraguant['q38']['a8']}</option>
                    <option value="thessia">{$fraguant['q38']['a9']}</option><option value="kai">{$fraguant['q38']['a10']}</option>
                    <option value="tali">{$fraguant['q38']['a11']}</option><option value="legion">{$fraguant['q38']['a12']}</option>
                    <option value="romance">{$fraguant['q38']['a13']}</option><option value="victus">{$fraguant['q38']['a14']}</option>
                    <option value="cans">{$fraguant['q38']['a15']}</option><option value="farewell">{$fraguant['q38']['a16']}</option>
                    <option value="ending">{$fraguant['q38']['a17']}</option><option value="eva">{$fraguant['q38']['a18']}</option>
                    <option value="samara">{$fraguant['q38']['a19']}</option><option value="grunt">{$fraguant['q38']['a20']}</option>
                    <option value="reaper">{$fraguant['q38']['a21']}</option><option value="death">{$fraguant['q38']['a22']}</option>
                </select>
            </td>
        </tr>
        <tr>
            <td class="label_q">{$fraguant['q18']['f']}</td>
            <td class="answers">
                <select name="q18">
                    <option selected="selected" value="destruction">{$fraguant['q18']['a1']}</option><option value="control">{$fraguant['q18']['a2']}</option>
                    <option value="synthesis">{$fraguant['q18']['a3']}</option>
                </select>
            </td>
        </tr>
        <tr>
            <td class="label_q">{$fraguant['q19']['f']}</td>
            <td class="answers">
                <select name="q19">
                    <option selected="selected" value="destruction">{$fraguant['q19']['a1']}</option><option value="control">{$fraguant['q19']['a2']}</option>
                    <option value="synthesis">{$fraguant['q19']['a3']}</option>
                </select>
            </td>
        </tr>
    </table>          
    <table id="questions_r">
        <tr>
            <td class="label_q">{$fraguant['q20']['f']}</td>
            <td class="answers">
                <select name="q20">
                    <option selected="selected" value="nice">{$fraguant['q20']['a1']}</option><option value="ok">{$fraguant['q20']['a2']}</option>
                    <option value="bad">{$fraguant['q20']['a3']}</option><option value="awful">{$fraguant['q20']['a4']}</option>
                </select>
            </td>
        </tr>
        <tr>
            <td class="label_q">{$fraguant['q21']['f']}</td>
            <td class="answers">
                <select name="q21">
                    <option selected="selected" value="yes">{$fraguant['q21']['a1']}</option><option value="no">{$fraguant['q21']['a2']}</option>
                    <option value="unsure">{$fraguant['q21']['a3']}</option>
                </select>
            </td>
        </tr>
        <tr>
            <td class="label_q">{$fraguant['q22']['f']}</td>
            <td class="answers">
                <select name="q22">
                    <option selected="selected" value="creator">{$fraguant['q22']['a1']}</option><option value="reaper">{$fraguant['q22']['a2']}</option>
                    <option value="higher">{$fraguant['q22']['a3']}</option><option value="nothing">{$fraguant['q22']['a4']}</option>
                </select>
            </td>
        </tr>
        <tr>
            <td class="label_q">{$fraguant['q23']['f']}</td>
            <td class="answers">
                <select name="q23">
                    <option selected="selected" value="yes">{$fraguant['q23']['a1']}</option><option value="no">{$fraguant['q23']['a2']}</option>
                    <option value="option">{$fraguant['q23']['a3']}</option>
                </select>
            </td>
        </tr>
        <tr>
            <td class="label_q">{$fraguant['q24']['f']}</td>
            <td class="answers">
                <select name="q24">
                    <option selected="selected" value="10">{$fraguant['q24']['a1']}</option><option value="9">9</option><option value="8">8</option><option value="7">7</option><option value="6">6</option>
                    <option value="5">{$fraguant['q24']['a2']}</option><option value="4">4</option><option value="3">3</option><option value="2">2</option><option value="1">1</option>
                    <option value="0">{$fraguant['q24']['a3']}</option>
                </select>
            </td>
        </tr>
        <tr>
            <td class="label_q">{$fraguant['q25']['f']}</td>
            <td class="answers">
                <select name="q25">
                    <option selected="selected" value="10">{$fraguant['q25']['a1']}</option><option value="9">9</option><option value="8">8</option><option value="7">7</option><option value="6">6</option>
                    <option value="5">{$fraguant['q25']['a2']}</option><option value="4">4</option><option value="3">3</option><option value="2">2</option><option value="1">1</option>
                    <option value="0">{$fraguant['q25']['a3']}</option>
                </select>
            </td>
        </tr>
        <tr>
            <td class="label_q">{$fraguant['q26']['f']}</td>
            <td class="answers">
                <select name="q26">
                    <option selected="selected" value="10">{$fraguant['q26']['a1']}</option><option value="9">9</option><option value="8">8</option><option value="7">7</option><option value="6">6</option>
                    <option value="5">{$fraguant['q26']['a2']}</option><option value="4">4</option><option value="3">3</option><option value="2">2</option><option value="1">1</option>
                    <option value="0">{$fraguant['q26']['a3']}</option>
                </select>
            </td>
        </tr>
        <tr>
            <td class="label_q">{$fraguant['q27']['f']}</td>
            <td class="answers">
                <select name="q27">
                    <option selected="selected" value="yes">{$fraguant['q27']['a1']}</option><option value="no">{$fraguant['q27']['a2']}</option>
                    <option value="maybe">{$fraguant['q27']['a3']}</option>
                </select>
            </td>
        </tr>
        <tr>
            <td class="label_q">{$fraguant['q28']['f']}</td>
            <td class="answers">
                <select name="q28">
                    <option selected="selected" value="yes">{$fraguant['q28']['a1']}</option><option value="no">{$fraguant['q28']['a2']}</option>
                    <option value="dknow">{$fraguant['q28']['a3']}</option>
                </select>
            </td>
        </tr>
        <tr>
            <td class="label_q">{$fraguant['q29']['f']}</td>
            <td class="answers">
                <select name="q29">
                    <option selected="selected" value="yes">{$fraguant['q29']['a1']}</option><option value="yesb">{$fraguant['q29']['a2']}</option>
                    <option value="no">{$fraguant['q29']['a3']}</option><option value="never">{$fraguant['q29']['a4']}</option>
                </select>
            </td>
        </tr>
        <tr>
            <td class="label_q">{$fraguant['q30']['f']}</td>
            <td class="answers">
                <select name="q30">
                    <option selected="selected" value="yesm">{$fraguant['q30']['a1']}</option><option value="yesl">{$fraguant['q30']['a2']}</option>
                    <option value="no">{$fraguant['q30']['a3']}</option>
                </select>
            </td>
        </tr>
        <tr>
            <td class="label_q">{$fraguant['q31']['f']}</td>
            <td class="answers">
                <select name="q31">
                    <option selected="selected" value="soldier">{$fraguant['q31']['a1']}</option><option value="vanguard">{$fraguant['q31']['a2']}</option>
                    <option value="infiltrator">{$fraguant['q31']['a3']}</option><option value="sentinel">{$fraguant['q31']['a4']}</option>
                    <option value="adept">{$fraguant['q31']['a5']}</option><option value="ingenieur">{$fraguant['q31']['a6']}</option>    
                </select>
            </td>
        </tr>
        <tr>
            <td class="label_q">{$fraguant['q32']['f']}</td>
            <td class="answers">
                <select name="q32">
                    <option selected="selected" value="daily">{$fraguant['q32']['a1']}</option><option value="weeklym">{$fraguant['q32']['a2']}</option>
                    <option value="weekly">{$fraguant['q32']['a3']}</option><option value="rarer">{$fraguant['q32']['a4']}</option><option value="never">{$fraguant['q32']['a5']}</option>
                </select>
            </td>
        </tr>
        <tr>
            <td class="label_q">{$fraguant['q33']['f']}</td>
            <td class="answers">
                <select name="q33">
                    <option selected="selected" value="halfhour">{$fraguant['q33']['a1']}</option><option value="hour">{$fraguant['q33']['a2']}</option>
                    <option value="hourm">{$fraguant['q33']['a3']}</option>
                </select>
            </td>
        </tr>
        <tr>
            <td class="label_q">{$fraguant['q34']['f']}</td>
            <td class="answers">
                <select name="q34">
                    <option selected="selected" value="classes">{$fraguant['q34']['a1']}</option><option value="species">{$fraguant['q34']['a2']}</option>
                    <option value="maps">{$fraguant['q34']['a3']}</option><option value="modes">{$fraguant['q34']['a4']}</option>
                    <option value="nothing">{$fraguant['q34']['a5']}</option>
                </select>
            </td>
        </tr> 
        <tr>
            <td class="label_q">{$fraguant['q35']['f']}</td>
            <td class="answers">
                <select name="q35">
                    <option selected="selected" value="10">{$fraguant['q35']['a1']}</option><option value="9">9</option><option value="8">8</option><option value="7">7</option><option value="6">6</option>
                    <option value="5">{$fraguant['q35']['a2']}</option><option value="4">4</option><option value="3">3</option><option value="2">2</option><option value="1">1</option>
                    <option value="0">{$fraguant['q35']['a3']}</option>
                </select>
            </td>
        </tr>
        <tr>
            <td class="label_q">{$fraguant['q36']['f']}</td>
            <td class="answers">
                <select name="q36">
                    <option selected="selected" value="10">{$fraguant['q36']['a1']}</option><option value="9">9</option><option value="8">8</option><option value="7">7</option><option value="6">6</option>
                    <option value="5">{$fraguant['q36']['a2']}</option><option value="4">4</option><option value="3">3</option><option value="2">2</option><option value="1">1</option>
                    <option value="0">{$fraguant['q36']['a3']}</option>
                </select>
            </td>
        </tr>
        <tr>
            <td class="label_q">{$fraguant['q37']['f']}</td>
            <td class="answers">
                <textarea name="q37" id="q37" onKeyDown="limitText(this.form.q37,this.form.countdown,140);" onKeyUp="limitText(this.form.q37,this.form.countdown,140);"></textarea>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
                <p style="clear:both;float:right"><input style="border: 3px solid red;" type="submit" value="{$send}"></p>
            </td>
        </tr>
        </table>
        <input type="hidden" value="{$lang}" name="lang">
</form>
DOC;
                  
$js = <<<DOC
<script type="text/javascript">
//Auswahleinschränkungen
$('#q9 select').change(function(){ 
    $(this).siblings('select').children('option[value=' + this.value + ']').attr('disabled', true).siblings().removeAttr('disabled');
});

$("#q11 option[value='ash']").attr('disabled',true);
$("#q11 option[value='tali']").attr('disabled',true);
$("#q11 option[value='miranda']").attr('disabled',true);
$("#q11 option[value='cortez']").attr('disabled',true);
$("#q11 option[value='jack']").attr('disabled',true);

$("#q11 option[value='garrus']").removeAttr('disabled');
$("#q11 option[value='kaidan']").removeAttr('disabled');
$("#q11 option[value='liara']").removeAttr('disabled');
$("#q11 option[value='semantha']").removeAttr('disabled');
$("#q11 option[value='thane']").removeAttr('disabled');

$('#q3').change(function(){
    if($("input[name='q3']:checked").val() == "male"){
        //$("#q11 option[value='kaidan']").attr('disabled',true);
        $("#q11 option[value='garrus']").attr('disabled',true);
        $("#q11 option[value='samantha']").attr('disabled',true);
        $("#q11 option[value='thane']").attr('disabled',true);
        
        $("#q11 option[value='ash']").removeAttr('disabled');
        $("#q11 option[value='liara']").removeAttr('disabled');
        $("#q11 option[value='cortez']").removeAttr('disabled');
        
        if($("input[name='q4']:checked").val() == "yes"){
            $("#q11 option[value='tali']").removeAttr('disabled');
            $("#q11 option[value='miranda']").removeAttr('disabled');
            $("#q11 option[value='jack']").removeAttr('disabled');
        }
        else{           
            $("#q11 option[value='tali']").attr('disabled',true);
            $("#q11 option[value='jack']").attr('disabled',true);
            $("#q11 option[value='miranda']").attr('disabled',true);  
            $("#q11 option[value='kaidan']").removeAttr('disabled');
        }
    }
    if($("input[name='q3']:checked").val() == "female"){
        $("#q11 option[value='ash']").attr('disabled',true);
        $("#q11 option[value='tali']").attr('disabled',true);
        $("#q11 option[value='miranda']").attr('disabled',true);
        $("#q11 option[value='cortez']").attr('disabled',true);
        $("#q11 option[value='jack']").attr('disabled',true);
        
        $("#q11 option[value='kaidan']").removeAttr('disabled');
        $("#q11 option[value='liara']").removeAttr('disabled');
        $("#q11 option[value='samantha']").removeAttr('disabled');
        
        if($("input[name='q4']:checked").val() == "yes"){
            $("#q11 option[value='garrus']").removeAttr('disabled');
            $("#q11 option[value='thane']").removeAttr('disabled');
        }
        else{
            $("#q11 option[value='garrus']").attr('disabled',true);
            $("#q11 option[value='thane']").attr('disabled',true);
            $("#q11 option[value='kaidan']").attr('disabled',true);
        }
    }
});

$('#q4').change(function(){
    if($("input[name='q4']:checked").val() == "no"){
        $("#q11 option[value='garrus']").attr('disabled',true);
        $("#q11 option[value='tali']").attr('disabled',true);
        $("#q11 option[value='miranda']").attr('disabled',true);
        $("#q11 option[value='jack']").attr('disabled',true);
        $("#q11 option[value='thane']").attr('disabled',true);
        $("#q11 option[value='kaidan']").attr('disabled',true);
        
        $("#q11 option[value='liara']").removeAttr('disabled');
        
        if($("input[name='q3']:checked").val() == "male"){
            $("#q11 option[value='kaidan']").attr('disabled',true);
            $("#q11 option[value='samantha']").attr('disabled',true);
            
            $("#q11 option[value='ash']").removeAttr('disabled');
            $("#q11 option[value='cortez']").removeAttr('disabled');
        }
        else{
            $("#q11 option[value='cortez']").attr('disabled',true);
            $("#q11 option[value='ash']").attr('disabled',true);
            
            $("#q11 option[value='kaidan']").removeAttr('disabled');
            $("#q11 option[value='samantha']").removeAttr('disabled');
        }
    }
    if($("input[name='q4']:checked").val() == "yes"){
        $("#q11 option[value='liara']").removeAttr('disabled');
        if($("input[name='q3']:checked").val() == "male"){
            $("#q11 option[value='garrus']").attr('disabled',true);
            //$("#q11 option[value='kaidan']").attr('disabled',true);
            $("#q11 option[value='samantha']").attr('disabled',true);
            $("#q11 option[value='thane']").attr('disabled',true);

            $("#q11 option[value='ash']").removeAttr('disabled');
            $("#q11 option[value='cortez']").removeAttr('disabled');
            $("#q11 option[value='tali']").removeAttr('disabled');
            $("#q11 option[value='miranda']").removeAttr('disabled');
            $("#q11 option[value='jack']").removeAttr('disabled');
            $("#q11 option[value='kaidan']").removeAttr('disabled');
        }
        else{
            $("#q11 option[value='tali']").attr('disabled',true);
            $("#q11 option[value='miranda']").attr('disabled',true);
            $("#q11 option[value='jack']").attr('disabled',true);
            $("#q11 option[value='cortez']").attr('disabled',true);
            $("#q11 option[value='ash']").attr('disabled',true);
            
            $("#q11 option[value='garrus']").removeAttr('disabled');
            $("#q11 option[value='kaidan']").removeAttr('disabled');
            $("#q11 option[value='samantha']").removeAttr('disabled');
            $("#q11 option[value='thane']").removeAttr('disabled');         
        }
    }
});

function limitText(limitField, limitCount, limitNum) {
	if (limitField.value.length > limitNum) {
		limitField.value = limitField.value.substring(0, limitNum);
	} else {
		limitCount.value = limitNum - limitField.value.length;
	}
}
//Abschicken
$("#poll_form").bind("submit", function() {

    if($("#q9_1").val() == "[Bitte wählen]" || 
       $("#q9_1").val() == "[Please choose]" ||
       $("#q9_2").val() == "[Please choose]" ||
       $("#q9_2").val() == "[Bitte wählen]" ||
       $("#q11").val() == "[Bitte wählen]" || 
       $("#q11").val() == "[Please choose]"){
        
        if($("#q11").val() == "[Bitte wählen]" || $("#q11").val() == "[Please choose]")
            $("#q11").css("border", "solid red 2px");
        if($("#q9_1").val() == "[Bitte wählen]" || $("#q9_1").val() == "[Please choose]")
            $("#q9_1,#q9_2").css("border", "solid red 2px");
        
        $("#poll_error").show();
        $.fancybox.resize();
        return false; 
    }
    
    $.fancybox.showActivity();

    $.ajax({
            'type'		  : "POST",
            'cache'               : false,
            'url'                 : "applets/umfrage.php",
            'data'		  : $(this).serializeArray(),
            'success': function(data) {
                $.fancybox(data);
            }
    });

    return false;
});
</script>
DOC;
}
else {
    $out = $error_string;
    $js = "";
}
echo $css;
echo $out;
echo $js;
?>
