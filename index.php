<?php

session_start();
//UNCOMMENT FOR DEBUG
error_reporting(E_ALL);
ini_set('display_errors', '1');
//Set Globals from config file
require_once("config.php");
//Connect to a database if it is configured
if (!empty($GLOBALS['db_flavor']) && !empty($GLOBALS['db_hostname'])) { //Assume the rest is GLOBALSured and go for it
    require_once("includes/db/{$GLOBALS['db_flavor']}.php");
} else {
    echo "Configure a database to continue"; //Coming soon! Initialization of the setup script!
}
require_once("includes/classes/login.php");
new login('justin', 'wieners');
//Get the mailer class set-up
require_once("includes/classes/mailer.php");

//Some placeholder stuff to make sure nothing died in initialization
echo "<br>
    <img src='images/icon.png'>";

?>
