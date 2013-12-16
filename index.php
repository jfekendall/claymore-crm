<?php
session_start();
//UNCOMMENT FOR DEBUG
//error_reporting(E_ALL);
//ini_set('display_errors', '1');

//Set Globals from config file
require_once("config.php");
//Connect to a database if it is configured
if (!empty($config['db_flavor']) && !empty($config['db_hostname'])) { //Assume the rest is configured and go for it
    require_once('includes/db/' . $config['db_flavor'] . '.php');
}else{
    echo "Configure a database to continue"; //Coming soon! Initialization of the setup script!
}
//Get the mailer class set-up
require_once("includes/classes/mailer.php");

//Some placeholder stuff to make sure nothing died in initialization
echo "Hello World<br>
    <img src='images/icon.png'>";
?>
