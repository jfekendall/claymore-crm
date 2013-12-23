<?php

/**
 *
 * @author justin
 */
class modules {

    public $installed;
    public $enabled;

    public function installed() {
        $installed = array();
        if ($modules_available = opendir('./includes/modules')) {
            while (false !== ($mod = readdir($modules_available))) {
                if ($mod != "." && $mod != "..") {
                    if ($features = opendir("./includes/modules/$mod")) {
                        while (false !== ($inst = readdir($features))) {
                            if ($inst != "." && $inst != "..") {
                                $installed[$mod]['feature'][] = $inst;
                            }
                        }
                        closedir($features);
                    }
                }
            }
            closedir($modules_available);
        }

        $this->installed = $installed;
        return $installed;
    }

    /*
     * Enabled outputs an array like this:
     * Array(
     *     [core] => Array
     *         (
     *             [enabled] => 1
     *             [mod_nav_order] => 0
     *             [feature] => Array
     *                 (
     *                     [0] => module_management.php
     *                     [1] => logoff.php
     *                     [2] => login.php
     *                 )
     *         )
     * )
     */

    public function enabled() {
        $enabled = array();
        $counter = 0;
        foreach (array_keys($this->installed()) AS $inst) {
            $exists_q = $GLOBALS['db']->query("SELECT count(id) FROM {$GLOBALS['db_table_prefix']}modules WHERE mod_name='$inst'");
            $is_registered = current($exists_q->fetch_row());
            if (!empty($is_registered) && $is_registered == 1) {

                $mod_enabled = $GLOBALS['db']->query("SELECT enabled, mod_nav_order, hide_in_nav FROM {$GLOBALS['db_table_prefix']}modules WHERE mod_name='$inst'");
                $mod_info = $mod_enabled->fetch_assoc();

                    $enabled[$inst]['enabled'] = $mod_info['enabled'];
                    $enabled[$inst]['mod_nav_order'] = $mod_info['mod_nav_order'];
                    if ($features = opendir("./includes/modules/$inst")) {
                        while (false !== ($mod = readdir($features))) {
                            if ($mod != "." && $mod != "..") {
                                $enabled[$inst]['feature'][] = $mod;
                            }
                        }
                        closedir($features);
                    }

            } else {
                $GLOBALS['db']->query("INSERT INTO {$GLOBALS['db_table_prefix']}modules (mod_name) VALUES ('$inst')");
            }
        }
        return $enabled;
    }

}

?>
