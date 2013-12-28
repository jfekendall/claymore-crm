<?php

$GLOBALS['db'] = new PDO("mysql:host={$GLOBALS['db_hostname']};dbname={$GLOBALS['db_database']};charset=utf8", $GLOBALS['db_username'], $GLOBALS['db_password']);
$GLOBALS['db']->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$GLOBALS['db']->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
?>
