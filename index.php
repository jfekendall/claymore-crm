<?php

session_start();
//error_reporting(E_ALL);
//ini_set('display_errors', '1');
//Set Globals from config file
require_once("config.php");
if (!empty($config['db_flavor']) && !empty($config['db_hostname'])) { //Assume the rest is configured and go for it
    require_once('includes/db/' . $config['db_flavor'] . '.php');
}
require_once("includes/classes/mailer.php");
echo "Hello World<br>
    <img src='images/icon.png'>";
?>
