<?php

switch ($_GET['type']) {
    case 'db':
        db_test();
        break;
}

function db_test() {
    $db = new mysqli($_GET['db_hostname'], $_GET['db_username'], $_GET['db_password'], $_GET['db_database']);
    if ($db->connect_errno > 0) {
        echo 'Server says: [' . $db->connect_error . ']';
    } else {
        echo "It works!";
    }
}

?>
