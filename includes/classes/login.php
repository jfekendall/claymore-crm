<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of login
 *
 * @author justin
 */
class login {

    private $user;
    private $password;
    private $auth_method;

    public function __construct($user, $password) {
        $this->user = $user;
        $this->password = $password;
        $this->auth_method = $GLOBALS[$config['auth_method']];
        echo $this->auth_method;
    }

    private function local_login() {
        
    }

}

?>
