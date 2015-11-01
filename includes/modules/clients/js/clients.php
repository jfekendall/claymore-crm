<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');
include("{$_SERVER['DOCUMENT_ROOT']}/config.php");
include("{$_SERVER['DOCUMENT_ROOT']}/includes/db/{$CONFIG['db_flavor']}.php");
$db = $CONFIG['db'];

switch ($_GET['i']) {
    case 'newClient':
        newClient();
        break;
}

function newClient() {
    global $db;
    try {
        $db->beginTransaction();
        $query = $db->prepare("INSERT INTO clients_accounts 
        (email, password)
    VALUES
        ('{$_GET['email']}','{$_GET['password']}')");
        $query->execute();
        $accountNumber = $CONFIG['db']->lastInsertId();
        $query = $db->prepare("INSERT INTO clients_locations 
        (account_id, business_name, is_main_office,phone,street_1, street_2, city, state, post_code)
    VALUES
        ('{$accountNumber}','{$_GET['business_name']}','{$_GET['is_main_office']}','{$_GET['phone']}','{$_GET['street_1']}','{$_GET['street_2']}','{$_GET['city']}','{$_GET['state']}','{$_GET['postal_code']}')");
        $query->execute();
        $db->commit();
        echo "{$_GET['business_name']} added with account# $accountNumber";
    } catch (PDOException $ex) {
        $db->rollBack();
        echo $ex->getMessage();
    }
}

?>
