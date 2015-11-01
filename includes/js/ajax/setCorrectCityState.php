<?php
include("../../../config.php");

$zip = current(explode('-', $_GET['zip']));
$correct = $CONFIG['db']->query("SELECT city, state FROM clients_us_zips WHERE zip='$zip' LIMIT 1");

if($correct->rowCount() != 0){
    $return = $correct->fetch(PDO::FETCH_ASSOC);
    echo ucwords(strtolower($return['city'])).",".$return['state'];
}

?>
