<?php if (!defined('ACP_GO')) die('Unauthorized access!');


###################
## Page Settings ##
###################
$news_cols = array('cat_id', 'user_id', 'news_date', 'news_title', 'news_text', 'news_prev', 'news_active', 'news_comments_allowed', 'news_search_update');

$FD->loadConfig('news');
$config_arr['html'] = in_array($FD->cfg('news', 'html_code'), array(2, 4)) ? $FD->text("admin", "on") : $FD->text("admin", "off");
$config_arr['fs'] = in_array($FD->cfg('news', 'fs_code'), array(2, 4)) ? $FD->text("admin", "on") : $FD->text("admin", "off");
$config_arr['para'] = in_array($FD->cfg('news', 'para_handling'), array(2, 4)) ? $FD->text("admin", "on") : $FD->text("admin", "off");

$config_arr['short_url_len'] = 50;
$config_arr['short_url_rep'] = '...';


// script
$adminpage->addCond('target_0', false);
$adminpage->addCond('target_1', false);
$adminpage->addCond('button', false);
$adminpage->addText('name_name', 'edit_name');
$adminpage->addText('url_name', 'edit_url');
$adminpage->addText('target_name', 'edit_target');
$adminpage->addText('class', 'space');
$edit_table = $adminpage->get('edit_table', false);

$adminpage->addText('table', $edit_table);
$script_edit = $adminpage->get('link_edit', false);

$adminpage->addCond('notscript', false);
$script_entry = $adminpage->get('link_entry', false);
$adminpage->addText('sul', $config_arr['short_url_len']);
$adminpage->addText('sur', $config_arr['short_url_rep']);
$adminpage->addText('link_entry', str_replace(array("\n","\r"), array('',''), $script_entry));
$adminpage->addText('link_edit', str_replace(array("\n","\r"), array('',''), $script_edit));
echo $adminpage->get('script', false);


/////////////////////////////
//// Insert News into DB ////
/////////////////////////////

if (
        !isset($_POST['edit_link']) && !isset($_POST['add_link']) &&
        isset($_POST['news_title']) && $_POST['news_title'] != '' &&
        isset($_POST['news_text']) && $_POST['news_text'] != '' &&
        isset($_POST['news_prev']) && $_POST['news_prev'] != '' &&

        isset($_POST['d']) && $_POST['d'] != '' && $_POST['d'] > 0 &&
        isset($_POST['m']) && $_POST['m'] != '' && $_POST['m'] > 0 &&
        isset($_POST['y']) && $_POST['y'] != '' && $_POST['y'] > 0 &&
        isset($_POST['h']) && $_POST['h'] != '' && $_POST['h'] >= 0 &&
        isset($_POST['i']) && $_POST['i'] != '' && $_POST['i'] >= 0 &&

        isset ( $_POST['cat_id'] ) && $_POST['cat_id'] != -1 &&
        isset ( $_POST['user_id'] ) && $_POST['cat_id'] != 0
    )
{
    // Prepare data
    $_POST['news_date'] = mktime($_POST['h'], $_POST['i'], 0, $_POST['m'], $_POST['d'], $_POST['y']);
    $_POST['news_search_update'] = 0;
    $data = frompost($news_cols);
    unset($data['news_id']);

    // SQL-Insert-Query
    try {
        // Get User
        try {
            $user_id = $FD->sql()->conn()->prepare(
                           'SELECT user_id FROM '.$FD->config('pref').'user
                           WHERE `user_name` = ? LIMIT 1');
            $user_id->execute(array($_POST['user_name']));
            $user_id = $user_id->fetchColumn();
        } catch (Exception $e) {
            Throw $e;
        }

        if (empty($user_id)) {
            Throw new FormException($FD->text('admin', 'no_user_found_for_name'));
        }

        $data['user_id'] = intval($user_id);

        // Save News
        $newsid = $sql->save('news', $data, 'news_id');

        // Update Search Index (or not)
        if ( $FD->config('cronjobs', 'search_index_update') === 1 ) {
            // Include searchfunctions.php
            require ( FS2_ROOT_PATH . 'includes/searchfunctions.php' );
            update_search_index ('news');
        }

        // Insert Links to database
        $stmt = $FD->sql()->conn()->prepare(
                    'INSERT INTO '.$FD->config('pref').'news_links
                     SET news_id = '.intval($newsid).',
                         link_name = ?,
                         link_url = ?,
                         link_target = ?');
        foreach ((array) $_POST['link_name'] as $id => $val)
        {
            if (!empty($_POST['link_name'][$id]) && !empty($_POST['link_url'][$id]) && !in_array($_POST['link_url'][$id], array('http://', 'https://'))) {

                // secure link target
                $_POST['link_target'][$id] = ($_POST['link_target'][$id] == 1 ? 1 : 0);

                // insert into db
                $stmt->execute(array($_POST['link_name'][$id], $_POST['link_url'][$id], $_POST['link_target'][$id]));
            }
        }

        // update counter
        try {
            $FD->sql()->conn()->exec('UPDATE `'.$FD->config('pref').'counter` SET `news` = `news` + 1 WHERE `id` = 1');
        } catch (Exception $e) {}

        echo get_systext($FD->text('page', 'news_added'), $FD->text('admin', 'info'), 'green', $FD->text('admin', 'icon_save_add'));

        // Unset Vars
        unset ($_POST);

    } catch (FormException $e) {
        echo get_systext($FD->text('page', 'news_not_added').'<br>'.$e->getMessage(),
        $FD->text('admin', 'unknown_user'), 'red', $FD->text('admin', 'icon_user_question'));
        $_POST['sended'] = "okay";
    } catch (Exception $e) {
        echo get_systext($FD->text('page', 'news_not_added').'<br>'.
        (DEBUG ? 'Caught exception: '.$e->getMessage() : $FD->text('admin', 'unknown_error')),
        $FD->text('admin', 'error'), 'red', $FD->text('admin', 'icon_save_error'));
    }

}

/////////////////////
///// News Form /////
/////////////////////

if ( TRUE ) {

    // link functions or error
    if (isset($_POST['sended'])) {

        //add link
        if (isset($_POST['add_link'])) {
            if (!empty($_POST['new_link_name']) && !empty($_POST['new_link_url']) && !in_array($_POST['new_link_url'], array('http://', 'https://'))) {
                $_POST['link_name'][] = $_POST['new_link_name'];
                $_POST['link_url'][] = $_POST['new_link_url'];
                $_POST['link_target'][] = $_POST['new_link_target'];

                unset($_POST['new_link_name'], $_POST['new_link_url'], $_POST['new_link_target']);
                $_POST['new_link_url'] = 'http://';
            } else {
                echo get_systext($FD->text('page', 'news_not_added').'<br>'.$FD->text('admin', 'form_not_filled'), $FD->text('admin', 'error'), 'red', $FD->text('admin', 'icon_link_error'));
            }

        //edit links
        } elseif (isset($_POST['edit_link'])) {

            if(isset($_POST['link']) && !empty($_POST['link_action'])) {

                // delete
                if ($_POST['link_action'] == 'del') {
                    unset($_POST['link_name'][$_POST['link']], $_POST['link_url'][$_POST['link']], $_POST['link_target'][$_POST['link']]);
                }

                //up
                elseif ($_POST['link_action'] == 'up' && $_POST['link'] != 0) {
                    // exchange values
                    list($_POST['link_name'][$_POST['link']-1], $_POST['link_name'][$_POST['link']])
                        = array($_POST['link_name'][$_POST['link']], $_POST['link_name'][$_POST['link']-1]);
                    list($_POST['link_url'][$_POST['link']-1], $_POST['link_url'][$_POST['link']])
                        = array($_POST['link_url'][$_POST['link']], $_POST['link_url'][$_POST['link']-1]);
                    list($_POST['link_target'][$_POST['link']-1], $_POST['link_target'][$_POST['link']])
                        = array($_POST['link_target'][$_POST['link']], $_POST['link_target'][$_POST['link']-1]);
                }

                //down
                elseif ($_POST['link_action'] == 'down' && $_POST['link'] < count($_POST['link_name'])-1) {
                    // exchange values
                    list($_POST['link_name'][$_POST['link']+1], $_POST['link_name'][$_POST['link']])
                        = array($_POST['link_name'][$_POST['link']], $_POST['link_name'][$_POST['link']+1]);
                    list($_POST['link_url'][$_POST['link']+1], $_POST['link_url'][$_POST['link']])
                        = array($_POST['link_url'][$_POST['link']], $_POST['link_url'][$_POST['link']+1]);
                    list($_POST['link_target'][$_POST['link']+1], $_POST['link_target'][$_POST['link']])
                        = array($_POST['link_target'][$_POST['link']], $_POST['link_target'][$_POST['link']+1]);
                }

                //edit
                elseif ($_POST['link_action'] == 'edit') {
                    $_POST['new_link_name'] = $_POST['link_name'][$_POST['link']];
                    $_POST['new_link_url'] = $_POST['link_url'][$_POST['link']];
                    $_POST['new_link_target'] = $_POST['link_target'][$_POST['link']];

                    unset($_POST['link_name'][$_POST['link']], $_POST['link_url'][$_POST['link']], $_POST['link_target'][$_POST['link']]);
                }
            }

        // display error
        } elseif ($_POST['sended'] != "okay") {
            echo get_systext($FD->text('page', 'news_not_added').'<br>'.$FD->text('admin', 'form_not_filled'), $FD->text("admin", "error"), 'red', $FD->text("admin", "icon_save_error"));
        }

    // Set default value
    } else {
        $_POST['news_active'] = 1;
        $_POST['news_comments_allowed'] = 1;
        $_POST['user_id'] = $_SESSION['user_id'];
        $_POST['user_name'] = $FD->sql()->conn()->query('SELECT user_name FROM '.$FD->config('pref').'user
                                                         WHERE user_id = '.intval($_POST['user_id']).' LIMIT 1');
        $_POST['user_name'] = $_POST['user_name']->fetchColumn();

        $_POST['d'] = date('d');
        $_POST['m'] = date('m');
        $_POST['y'] = date('Y');
        $_POST['h'] = date('H');
        $_POST['i'] = date('i');

        $_POST['new_link_url'] = 'http://';
    }

    // security functions
    $_POST = array_map('killhtml', $_POST);

    // Create Date-Arrays
    list($_POST['d'], $_POST['m'], $_POST['y'], $_POST['h'], $_POST['i'])
        = array_values(getsavedate($_POST['d'], $_POST['m'], $_POST['y'], $_POST['h'], $_POST['i'], 0, true));

    // cat options
    initstr($cat_options);
    if (!isset($_POST['cat_id']))
      $_POST['cat_id'] = 0;
    if ($FD->cfg('news', 'acp_force_cat_selection') == 1) {
        $cat_options .= '<option value="-1" '.getselected(-1, $_POST['cat_id']).'>'.$FD->text("admin", "please_select").'</option>'."\n";
        $cat_options .= '<option value="-1">'.$FD->text("admin", "select_hr").'</option>'."\n";
    }

    $cats = $FD->sql()->conn()->query('SELECT cat_id, cat_name FROM '.$FD->config('pref').'news_cat');
    $cats = $cats->fetchAll(PDO::FETCH_ASSOC);
    foreach ($cats as $cat) {
        settype ($cat['cat_id'], 'integer');
        $cat_options .= '<option value="'.$cat['cat_id'].'" '.getselected($cat['cat_id'], $_POST['cat_id']).'>'.$cat['cat_name'].'</option>'."\n";
    }


    //link entries
    initstr($link_entries);
    $c = 0;
    if (!isset($_POST['link_name']) || !is_array($_POST['link_name']))
        $_POST['link_name'] = array();

    foreach($_POST['link_name'] as $id => $val) {
        $adminpage->addCond('notscript', true);
        $adminpage->addText('name', killhtml($_POST['link_name'][$id]));
        $adminpage->addText('url', killhtml($_POST['link_url'][$id]));
        $adminpage->addText('target', killhtml($_POST['link_target'][$id]));
        $adminpage->addText('short_url', killhtml(cut_in_string($_POST['link_url'][$id], $config_arr['short_url_len'], $config_arr['short_url_rep'])));
        $adminpage->addText('target_text', $_POST['link_target'][$id] == 1 ? $FD->text("page", "news_link_blank") : $FD->text("page", "news_link_self"));
        $adminpage->addText('id', $c++);
        $adminpage->addText('num', $c);
        $link_entries .= $adminpage->get('link_entry')."\n";
    }

    // link list
    $adminpage->addCond('link_edit', $c >= 1);
    $adminpage->addText('link_entries', $link_entries);
    $link_list = $adminpage->get('link_list');

    //link add
    $adminpage->addCond('target_0', isset($_POST['new_link_target']) && $_POST['new_link_target'] === 0);
    $adminpage->addCond('target_1', isset($_POST['new_link_target']) && $_POST['new_link_target'] === 1);
    $adminpage->addCond('button', true);
    $adminpage->addText('name', isset($_POST['new_link_name']) ? $_POST['new_link_name'] : '');
    $adminpage->addText('name_name', 'new_link_name');
    $adminpage->addText('url', $_POST['new_link_url']);
    $adminpage->addText('url_name', 'new_link_url');
    $adminpage->addText('target_name', 'new_link_target');
    $adminpage->addText('class', 'spacebottom');
    $edit_table = $adminpage->get('edit_table');

    $adminpage->addText('table', $edit_table);
    $link_add = $adminpage->get('link_add');

    // Conditions
    $adminpage->addCond('news_active', $_POST['news_active'] === 1);
    $adminpage->addCond('news_comments_allowed', $_POST['news_comments_allowed'] === 1);

    // Values
    unset($_POST['link_name'], $_POST['link_url'], $_POST['link_target']);
    foreach ($_POST as $key => $value) {
        $adminpage->addText($key, $value);
    }

    $adminpage->addText('cat_options', $cat_options);
    $adminpage->addText('html', $config_arr['html']);
    $adminpage->addText('fs', $config_arr['fs']);
    $adminpage->addText('para', $config_arr['para']);
    $adminpage->addText('the_editor', create_editor('news_text', isset($_POST['news_text']) ? $_POST['news_text'] : '', '', '250px', 'full', FALSE));
    $adminpage->addText('prev_editor', create_editor('news_prev', isset($_POST['news_prev']) ? $_POST['news_prev'] : '', '', '250px', 'full', FALSE));
    $adminpage->addText('link_list', $link_list);
    $adminpage->addText('link_add', $link_add);

    // display page
    echo $adminpage->get('main');
}

?>
