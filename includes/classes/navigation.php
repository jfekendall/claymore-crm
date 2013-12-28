<?php

/**
 * Description of navigation
 *
 * @author justin
 */
class navigation extends modules {

    public function nav() {
        $mods_enabled_info = parent::enabled();
        $rs = '';
        foreach($GLOBALS['db']->query("SELECT * FROM {$GLOBALS['db_table_prefix']}modules WHERE enabled=1 ORDER BY mod_nav_order") AS $en) {
           //print_r($en);
            if (sizeof($mods_enabled_info[$en['mod_name']]['feature']) == 1) {
                $rs .= "<li>
                <a href='{$GLOBALS['base_url']}/" . strtolower($en['mod_name']) . "'>
                    " . ucwords(str_replace('_', ' ', $en['mod_name'])) . "
                </a></li>";
            } else {
                $rs .= "<li class='dropdown'>
                <a href='#' class='dropdown-toggle' data-toggle='dropdown'>
                <span class='caret'></span>";
                if ($en == 'core') {
                    $rs .= 'Options';
                } else {
                    $rs .= ucwords($en['mod_name']);
                }
                $rs .= "</a>
                    <ul class='dropdown-menu'>";
                foreach ($mods_enabled_info[$en['mod_name']]['feature'] AS $feature) {
                    if ($feature != 'login.php') {
                        $rs .= "<li>
                                <a href='" . strtolower(current(explode('.php', $feature))) . "'>
                                    " . ucwords(str_replace('_', ' ', current(explode('.php', $feature)))) . "
                                </a>
                            </li>";
                    }
                }
                $rs .= "</ul>
                </li>";
            }
        }
        return $rs;
    }

}

?>
