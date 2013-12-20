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
                    $installed[] = $mod;
                }
            }
            closedir($modules_available);
        }
        $this->installed = $installed;
        return $installed;
    }

    public function enabled() {
        $enabled = array();
        $counter = 0;
        foreach ($this->installed() AS $inst) {
            if ($inst == 'core') {
                if ($core_mods = opendir('./includes/modules/core')) {
                    while (false !== ($mod = readdir($core_mods))) {
                        if (stristr($mod, '.php')) {
                            $enabled[$mod] = array(
                                'dir' => 'core'
                            );
                            $counter++;
                        }
                    }
                    closedir($core_mods);
                }
            } else {
                $exists_q = $GLOBALS['db']->query("SELECT count(id) FROM {$GLOBALS['db_table_prefix']}modules WHERE mod_name='$inst'");
                $is_registered = current($exists_q->fetch_row());
                if (!empty($is_registered) && $is_registered == 1) {
                    $mod_enabled = $GLOBALS['db']->query("SELECT enabled FROM {$GLOBALS['db_table_prefix']}modules WHERE mod_name='$inst'");

                    if (current($mod_enabled->fetch_row()) == 1) {
                        $enabled[$inst] = array(
                            'dir' => $inst
                        );
                        $counter++;
                    }
                } else {
                    $GLOBALS['db']->query("INSERT INTO {$GLOBALS['db_table_prefix']}modules (mod_name) VALUES ('$inst')");
                }
            }
        }
        return $enabled;
    }

}

?>
