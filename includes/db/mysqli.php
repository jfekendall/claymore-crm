<?php

$CONFIG['db'] = new PDO("mysql:host={$CONFIG['db_hostname']};dbname={$CONFIG['db_database']};charset=utf8", $CONFIG['db_username'], $CONFIG['db_password']);
$CONFIG['db']->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$CONFIG['db']->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
?>
