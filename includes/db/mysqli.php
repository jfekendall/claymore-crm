<?php
$db = new mysqli($config['db_hostname'], $config['db_username'], $config['db_password'], $config['db_database']);
if($db->connect_errno > 0){
    die('Something is wrong in your configuration. Server says: [' . $db->connect_error . ']');
}
?>
