<?php
########################################
#### explanation of editor creation ####
########################################
/*
    $TEMPLATE_GO = ""; //$_GET-variable "go", important to stay at the same page ;)
    unset($tmp); //unsets $tmp for safety-issues
    
    $tmp[name] = "name"; //name of the template's db-entry
    $tmp[title] = "title"; //title of the template
    $tmp[description] = "description"; //short description of what the template is for
    $tmp[rows] = "x"; //number of rows of the textarea
    $tmp[cols] = "y"; //number of cols of the textarea
        $tmp[help][0][tag] = "{tag}"; //{tag}s which may be used in the template
        $tmp[help][0][text] = "text"; //description of the tag, shown at the tooltip
        $tmp[help][...][tag] = "{tag}"; //continue with numbers after [help]
        $tmp[help][...][text] = "text"; //to add more possible tags
    $TEMPLATE_EDIT[] = $tmp; //$tmp is no saved in the template-creation-array
    unset($tmp); //unsets $tmp for safety-issues
    
    $TEMPLATE_EDIT[] = false; //creates a vertcal bar to separate templates, here is no need of $tmp

    //continue with new templates just remind to add them at the end with $TEMPLATE_EDIT[] = $tmp;
    ...
*/
##########################################
#### / explanation of editor creation ####
##########################################

    $TEMPLATE_GO = "jstemplate";
    unset($tmp);
    
    $tmp[name] = "js_userfunctions";
    $tmp[title] = $admin_phrases[template][js_userfunctions][title];;
    $tmp[description] = $admin_phrases[template][js_userfunctions][description];
    $tmp[rows] = "30";
    $tmp[cols] = "66";
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);
        
//////////////////////////
//// Intialise Editor ////
//////////////////////////

if (templatepage_postcheck($TEMPLATE_EDIT))
{
    templatepage_save($TEMPLATE_EDIT);
    systext("Template wurde aktualisiert");
}
else
{
    echo create_templatepage ($TEMPLATE_EDIT, $TEMPLATE_GO);
}
?>