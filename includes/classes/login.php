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

        if (in_array($CONFIG['auth_method'], $supported_methods)) {
            echo $this->$CONFIG['auth_method']();
        } else {
            echo "Your auth_method value is not supported";
        }
    }

    private function local() {
        $allowed = $CONFIG['db']->query("
            SELECT id
            FROM `{$CONFIG['db_table_prefix']}users`
            WHERE 
                `username` = '$this->user'
            AND
                `password` = '" . hash($CONFIG['auth_password_hash_algo'], $this->password) . "'");

        if ($allowed->rowCount()) {
            $id = $allowed->fetch(PDO::FETCH_ASSOC);
            setcookie("claymore_user", $id['id'], time() + $CONFIG['auth_expire_time']);
            header("Location: {$CONFIG['base_url']}");
        } else {
            $CONFIG['errors'] .= "Username or password is incorrect"; //future home of redirect back to login with error.
        }
    }

}

?>
