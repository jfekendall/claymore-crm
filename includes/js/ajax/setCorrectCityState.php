<?php
include("{$_SERVER['DOCUMENT_ROOT']}/config.php");
include("../../db/{$CONFIG['db_flavor']}.php");

$zip = current(explode('-', $_GET['zip']));
$correct = $CONFIG['db']->query("SELECT city, state FROM us_zipcodes WHERE zipcode='$zip' LIMIT 1");

if($correct->rowCount() != 0){
    $return = $correct->fetch(PDO::FETCH_ASSOC);
    echo ucwords(strtolower($return['city'])).",".$return['state'];
}

?>
