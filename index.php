<?php

session_start();
//UNCOMMENT FOR DEBUG
error_reporting(E_ALL);
ini_set('display_errors', '1');
if ($_SERVER['SERVER_PORT'] == 80) {
    $base_url = 'http://' . $_SERVER['SERVER_NAME'];
} else {
    $base_url = 'https://' . $_SERVER['SERVER_NAME'];
}
$errors = $out = '';
require_once("includes/classes/template.php");

//Set Globals from config file
if (file_exists('config.php') && !empty($GLOBALS['db_hostname'])) {
    require_once("config.php");
} else if (empty($GLOBALS['db_hostname'])){
    $replace = array();
    $GLOBALS['base_url'] = $replace['base_url'] = $base_url;
    $GLOBALS['template'] = $replace['template'] = 'default';
    $replace['errors'] = '';
    require_once('setup/dependancies.php');
    require_once('setup/setup.php');
    $output = new setup();
    $stuff = $output->stuff(new dependancies);
    //$replace['header'] = $stuff['header'];
    $replace['stuff'] = $stuff['stuff'];
    $out = new template('setup_template.html');
    echo $out->out($replace);
    die();
}
//Connect to a database if it is configured
if (!empty($GLOBALS['db_flavor']) && !empty($GLOBALS['db_hostname'])) { //Assume the rest is GLOBALSured and go for it
    require_once("includes/db/{$GLOBALS['db_flavor']}.php");
} else {
    die("Configure a database to continue"); //Coming soon! Initialization of the setup script!
}
require_once("includes/classes/modules.php");
require_once("includes/classes/traffic_cop.php");
$verdict = new traffic_cop();
if (!empty($verdict->return['module'])) {
    require_once("includes/modules/{$verdict->return['module']}");
    $class = current(explode('.', end(explode('/', $verdict->return['module']))));
    $module = new $class();
    $out = $module->out();
    foreach (array_keys($out) AS $replacement) {
        $replace[$replacement] = $out[$replacement];
    }
}
require_once("includes/classes/navigation.php");
$nav = new navigation();

if (!empty($GLOBALS['errors'])) {
    $GLOBALS['errors'] = "<div class='alert alert-danger'>{$GLOBALS['errors']}</div>";
}

if (file_exists("{$_SERVER['DOCUMENT_ROOT']}/template/{$GLOBALS['template']}/{$verdict->return['template']}")) {
    $out = new template($verdict->return['template']);
} else {
    $out = new template('index_template.html');
}
$replace['nav'] = $nav->nav();
$replace['errors'] = $GLOBALS['errors'];

echo $out->out($replace);
?>
