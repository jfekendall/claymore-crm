<?php

//error_reporting(E_ALL);
//ini_set('display_errors', '1');
include("{$_SERVER['DOCUMENT_ROOT']}/config.php");
include("../../db/{$GLOBALS['db_flavor']}.php");

setcookie("claymore_user", $_COOKIE['claymore_user'], time() + $GLOBALS['auth_expire_time']);

switch ($_GET['action']) {
    case "enableModule":
        enableModule();
        break;
    case "removeModule":
        removeModule();
        break;
    case "changeNavOrder":
        changeNavOrder();
        break;
}

function changeNavOrder() {
    $GLOBALS['db']->query("UPDATE {$GLOBALS['db_table_prefix']}modules 
    SET 
        mod_nav_order='{$_GET['mod_nav_order']}'
    WHERE 
        mod_name='{$_GET['module']}'");
}

function enableModule() {
    if ($_GET['current_state'] == 'false') {
        $bit = 0;
    } else {
        $bit = 1;
    }
    $GLOBALS['db']->query("UPDATE {$GLOBALS['db_table_prefix']}modules 
    SET 
        enabled=$bit 
    WHERE 
        mod_name='{$_GET['module']}'");
}

function removeModule() {
    $manifest = explode("\n", file_get_contents("{$_SERVER['DOCUMENT_ROOT']}/includes/modules/{$_GET['module']}/manifest"));
    foreach ($manifest AS $file) {
        if (!unlink("{$_SERVER['DOCUMENT_ROOT']}/$file")) {
            die("Permissions aren't right on {$_SERVER['DOCUMENT_ROOT']}/$file");
        }
    }
    rmdir("{$_SERVER['DOCUMENT_ROOT']}/includes/modules/{$_GET['module']}");
    $GLOBALS['db']->query("DELETE FROM {$GLOBALS['db_table_prefix']}modules 
    WHERE 
        mod_name='{$_GET['module']}'");
}

?>
