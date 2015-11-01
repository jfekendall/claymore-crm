<?php

switch ($_GET['type']) {
    case 'db':
        db_test();
        break;
}

function db_test() {
    try {
        $db = new PDO("mysql:host={$_GET['db_hostname']};dbname={$_GET['db_database']};charset=utf8", $_GET['db_username'], $_GET['db_password'], array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        echo "It works!";
    } catch (PDOException $ex) {
        echo "Failed to connect: $ex";
    }
}

?>
