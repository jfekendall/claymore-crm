<?php

/**
 * Description of navigation
 *
 * @author justin
 */
class navigation extends modules {

    public function nav() {
        $enabled = parent::enabled();
        $rs = '';
        foreach (array_keys($enabled) as $en) {
            if ($enabled[$en]['enabled'] == 1) {
                if (sizeof($enabled[$en]['feature']) == 1) {
                    $rs .= "<li>
                <a href='" . strtolower(current(explode('.php', $en))) . "'>
                    " . ucwords(str_replace('_', ' ', current(explode('.php', $en)))) . "
                </a></li>";
                } else {
                    $rs .= "<li class='dropdown'>
                <a href='#' class='dropdown-toggle' data-toggle='dropdown'>
                <span class='caret'></span>";
                    if ($en == 'core') {
                        $rs .= 'Options';
                    } else {
                        $rs .= ucwords($en);
                    }
                    $rs .= "</a>
                    <ul class='dropdown-menu'>";
                    foreach ($enabled[$en]['feature'] AS $feature) {
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
        }
        return $rs;
    }

}

?>
