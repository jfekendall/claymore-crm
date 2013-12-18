<?php

/**
 * 
 * @author justin
 */
class login {

    private $user;
    private $password;

    public function __construct($user, $password) {
        $supported_methods = array('local', 'ldap');
        $this->user = $user;
        $this->password = $password;
        if (in_array($GLOBALS['auth_method'], $supported_methods)) {
            echo $this->$GLOBALS['auth_method']();
        } else {
           echo  "Your auth_method value is not supported";
        }
    }

    private function local() {
        $allowed = "
            SELECT id
            FROM `{$GLOBALS['db_table_prefix']}users`
            WHERE 
                `username` = '$this->user'
            AND
                `password` = '" . hash($GLOBALS['auth_password_hash_algo'], $this->password) . "'";

        if (!$result = $GLOBALS['db']->query($allowed)) {
            die('users table is not configured');
        } else {
            if ($id = $result->fetch_assoc()) {
                setcookie("claymore_user", $id['id'], time() + $GLOBALS['auth_expire_time']);
            } else {
                $GLOBALS['errors'] .= "Username or password is incorrect"; //future home of redirect back to login with error.
            }
        }
    }

}

?>
