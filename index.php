<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');
//Set Globals from config file
require_once("config.php");
require_once("includes/classes/mailer.php");
echo "Hello World<br>
    <img src='images/icon.png'>";
?>
