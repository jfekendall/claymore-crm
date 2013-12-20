<?php

/**
 * @author justin
 */
class traffic_cop extends modules {

    private $section;
    public $return = array();

    function __construct() {
        $this->section = @$_GET['section'];
        if (!isset($this->section)) {
            $this->section = 'index';
        } else if ($this->section == 'logoff') {
            setcookie("claymore_user", "", time() - 3600); //handle logoff
            header("Location: {$GLOBALS['base_url']}/login");
        }

        /*
         * Check Authentication Credentials
         */
        
        if (!$this->check_id()) {
            //GO TO JAIL!
            $this->return['template'] = 'login_template.html';
            return;
        } else {
            //Good to go 
            $this->return['template'] = "{$this->section}_template.html";
           // setcookie("claymore_user", $_COOKIE['claymore_user'], time() + $GLOBALS['auth_expire_time']);
        }
        $enabled = parent::enabled();
        if (in_array(str_replace(' ', '_', $this->section), array_keys($enabled))) {
            $this->return['module'] = $enabled[str_replace(' ', '_', $this->section)]['dir'] . '/' . str_replace(' ', '_', $this->section) . '.php';
        } else if (in_array(str_replace(' ', '_', $this->section) . '.php', array_keys($enabled))) {
            $this->return['module'] = $enabled[str_replace(' ', '_', $this->section) . '.php']['dir'] . '/' . str_replace(' ', '_', $this->section) . '.php';
        }

        /*
         * TODO: Routing for modules
         */
    }

    private function check_id() {
        if (!isset($_COOKIE['claymore_user']) && $this->section != 'login') {
            return false; //go to jail
        } else if (!isset($_COOKIE['claymore_user']) && $this->section == 'login' && isset($_POST['username'])) {
            require_once("login.php");
            new login($_POST['username'], $_POST['password']);
            if (isset($_COOKIE['claymore_user'])) {
                return true;
            } else {
                return false; //go to jail
            }
        } else if ($this->section == 'login' && !isset($_COOKIE['claymore_user'])) {
            return false; //go to jail
        } else {
            return true;
        }
    }

    private function go_here() {
        
    }

}

?>
