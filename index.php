<?php

session_start();
//UNCOMMENT FOR DEBUG
error_reporting(E_ALL);
ini_set('display_errors', '1');
//
$errors = $out = '';
require_once("includes/classes/template.php");
//
//Set Globals from config file
require_once("config.php");
//Connect to a database if it is configured

if (!empty($GLOBALS['db_flavor']) && !empty($GLOBALS['db_hostname'])) { //Assume the rest is GLOBALSured and go for it
    require_once("includes/db/{$GLOBALS['db_flavor']}.php");
} else {
    die("Configure a database to continue"); //Coming soon! Initialization of the setup script!
}
print_r($_GET);
if (!isset($_COOKIE['claymore_user']) && $_GET['section'] != 'login') {
    $out = new template('login_template.html');
}else if(!isset($_COOKIE['claymore_user']) && $_GET['section'] == 'login' && isset($_POST['claymore_username'])){
    require_once("includes/classes/login.php");
    new login($_POST['claymore_username'], $_POST['password']);
}else if($_GET['section'] == 'login'){
    $out = new template('login_template.html');
}


require_once("includes/classes/modules.php");
require_once("includes/classes/navigation.php");
$nav = new navigation();
$nav = $nav->nav();

if (!empty($GLOBALS['errors'])) {
    $GLOBALS['errors'] = "<div class='alert alert-danger'>{$GLOBALS['errors']}</div>";
}

if (empty($out)) {
    $out = new template('index_template.html');
}

$replace = array(
    'title' => 'Claymore CRM',
    'template' => 'default',
    'copyright' => 'Proudly Powered by Claymore CRM',
    'errors' => $GLOBALS['errors'],
    'nav' => $nav,
    'base_url' => 'http://claymoretest.com/'
);
echo $out->out($replace);
?>
