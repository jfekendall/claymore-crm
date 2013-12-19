<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of traffic_cop
 *
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
            setcookie("claymore_user", "", time() - 3600);
        }

        if (!$this->check_id()) {
            $this->return['template'] = 'login_template.html';
        } else {
            $this->return['template'] = "{$this->section}_template.html";
        }
    }

    private function check_id() {
        if (!isset($_COOKIE['claymore_user']) && $this->section != 'login') {
            return false;
        } else if (!isset($_COOKIE['claymore_user']) && $this->section == 'login' && isset($_POST['username'])) {
            require_once("login.php");
            new login($_POST['username'], $_POST['password']);
            if (isset($_COOKIE['claymore_user'])) {
                return true;
            } else {
                return false;
            }
        } else if ($this->section == 'login' && !isset($_COOKIE['claymore_user'])) {
            return false;
        } else {
            return true;
        }
    }

}

?>
