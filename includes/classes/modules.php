<?php

/**
 *
 * @author justin
 */
class modules {

    public $installed;
    public $enabled;
    private $config = array();

    function __construct($config) {
        $this->config = $config;
    }

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
        extract($GLOBALS['CONFIG']);
        foreach (array_keys($this->installed()) AS $inst) {
            $exists_q = $db->query("SELECT count(id) FROM {$db_table_prefix}modules WHERE mod_name='$inst'");
            $is_registered = current($exists_q->fetch(PDO::FETCH_ASSOC));
            if (!empty($is_registered) && $is_registered == 1) {

                $mod_enabled = $db->query("SELECT enabled, mod_nav_order, hide_in_nav FROM {$db_table_prefix}modules WHERE mod_name='$inst'");
                $mod_info = $mod_enabled->fetch(PDO::FETCH_ASSOC);
                $enabled[$inst]['enabled'] = $mod_info['enabled'];
                $enabled[$inst]['mod_nav_order'] = $mod_info['mod_nav_order'];
                if ($features = opendir("./includes/modules/$inst")) {
                    while (false !== ($mod = readdir($features))) {
                        if ($mod != "." && $mod != ".." && !is_dir("./includes/modules/$inst/$mod")) {
                            $enabled[$inst]['feature'][] = $mod;
                        }
                    }
                    closedir($features);
                }
            } else {
                $db->query("INSERT INTO {$db_table_prefix}modules (mod_name) VALUES ('$inst')");
            }
        }
        return $enabled;
    }

}

?>
