<?php
$GLOBALS['db'] = new mysqli($GLOBALS['db_hostname'], $GLOBALS['db_username'], $GLOBALS['db_password'], $GLOBALS['db_database']);
if($GLOBALS['db']->connect_errno > 0){
    die('Something is wrong in your configuration. Server says: [' . $GLOBALS['db']->connect_error . ']');
}
?>
