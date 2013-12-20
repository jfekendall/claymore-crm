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
            if ($en != 'login.php') {
                $rs .= "<li>
                <a href='" . strtolower(current(explode('.php', $en))) . "'>
                    " . ucwords(str_replace('_', ' ', current(explode('.php', $en)))) . "
                </a>
            </li>";
            }
        }
        return $rs;
    }

}

?>
