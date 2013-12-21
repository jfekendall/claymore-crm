<?php

session_start();
//UNCOMMENT FOR DEBUG
error_reporting(E_ALL);
ini_set('display_errors', '1');

$errors = $out = '';
require_once("includes/classes/template.php");

//Set Globals from config file
require_once("config.php");
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
