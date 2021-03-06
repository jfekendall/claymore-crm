<?php

session_start();
//UNCOMMENT FOR DEBUG
//error_reporting(E_ALL);
ini_set('display_errors', '0');

$errors = $out = '';
require_once("includes/classes/template.php");

//Set Globals from config file
if (file_exists('config.php')) {
    require_once("config.php");
}
if (empty($CONFIG['db_hostname'])) {
    if ($_SERVER['SERVER_PORT'] == 80) {
        $base_url = 'http://' . $_SERVER['SERVER_NAME'] . str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);
    } else {
        $base_url = 'https://' . $_SERVER['SERVER_NAME'] . str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);
    }
    $base_dir = $CONFIG['base_dir'] = str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']);
    $replace = array();
    $CONFIG['base_url'] = $replace['base_url'] = $base_url;
    $CONFIG['template'] = $replace['template'] = 'default';
    $replace['errors'] = '';
    require_once('setup/dependancies.php');
    require_once('setup/setup.php');
    $output = new setup($CONFIG);
    $stuff = $output->stuff(new dependancies($base_dir));
    $replace['stuff'] = $stuff['stuff'];
    $out = new template('setup_template.html', $CONFIG);
    echo $out->out($replace);
}

//Connect to a database if it is configured
if (!empty($CONFIG['db_flavor']) && !empty($CONFIG['db_hostname'])) { //Assume the rest is configured and go for it
    require_once("includes/db/{$CONFIG['db_flavor']}.php");
} else {
    die("Configure a database to continue");
}
require_once("includes/classes/sort_on.php");
require_once("includes/classes/modules.php");
require_once("includes/classes/traffic_cop.php");
require_once("includes/classes/formElements.php");
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
$nav = new navigation($CONFIG);
if (!empty($CONFIG['errors'])) {
    $CONFIG['errors'] = "<div class='alert alert-danger'>{$CONFIG['errors']}</div>";
}

if (file_exists("{$CONFIG['base_dir']}/template/{$CONFIG['template']}/{$verdict->return['template']}")) {
    $out = new template($verdict->return['template'], $CONFIG);
} else {
    $out = new template('index_template.html', $CONFIG);
}
$replace['nav'] = $nav->nav($CONFIG);
$replace['errors'] = $CONFIG['errors'];

echo $out->out($replace);
?>
