<?php

/**
 * @author justin
 */
class dependancies {

    private $dir = '';

    function __construct($base_dir) {
        $this->dir = $base_dir;
    }

    public function deps() {
        return array(
            "Config File Writable" => $this->config_writable(),
            "mod_rewrite enabled" => $this->mod_rewrite(),
            "Mysqli enabled" => $this->has_php5_mysqli(),
        );
    }

    private function apache_mods() {
        return apache_get_modules();
    }

    public function os() {
        return $_SERVER['SERVER_SOFTWARE'];
    }

    public function has_php5_mysqli() {
        if (extension_loaded('mysqli')) {
            return true;
        }
        return false;
    }

    public function has_php5_mssql() {
        if (extension_loaded('mssql')) {
            return true;
        }
        return false;
    }

    public function mod_rewrite() {
        if (in_array('mod_rewrite', $this->apache_mods())) {
            return true;
        }
        return false;
    }

    public function config_writable() {

        if (is_writable("{$this->dir}config.php")) {
            return true;
        } else if (file_put_contents("{$this->dir}config.php", " ")) {
            chmod("{$this->dir}config.php", 0664);
            return true;
        }
        return false;
    }

}

?>
