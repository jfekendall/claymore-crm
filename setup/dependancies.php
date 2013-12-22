<?php

/**
 * @author justin
 */
class dependancies {

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
        
        if (is_writable("{$_SERVER['DOCUMENT_ROOT']}/config.php")) {
            return true;
        }else if(file_put_contents("{$_SERVER['DOCUMENT_ROOT']}/config.php" , "<?php\n\$GLOBALS = array();\n\$globals['errors']='';")){
            return true;
        }
        return false;
    }

}

?>
