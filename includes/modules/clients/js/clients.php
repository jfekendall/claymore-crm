<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');
include("../../../../config.php");
$db = $CONFIG['db'];

switch ($_GET['i']) {
    case 'newClient':
        newClient();
        break;
    case 'clientInfo':
        clientInfo();
        break;
}
function clientInfo(){
    global $db;
    //TODO: Make look pretty. Separate html into a template.
    echo '<div class="container"><div class="row" "><div class="col-md-12">
        <ul class="nav nav-pills" style="background:transparent;margin:0;">
  <li class="active"><a href="javascript:void(0);" onclick="$(\'.info\').hide();$(\'.enterprise_info\').show();">Enterprise Information</a></li>
  <li><a href="javascript:void(0);" onclick="$(\'.info\').hide();">Locations</a></li>
  <li><a href="#">Employees</a></li>
  <li><a href="#">Account Information</a></li>
</ul></div></div>';
    echo "<div class='row info enterprise_info'>";
    $info = $db->query("SELECT * FROM clients_locations WHERE id={$_GET['id']}");
    $einfo = $info->fetch(PDO::FETCH_ASSOC);
    foreach(array_keys($einfo) AS $e){
        if(in_array($e, array('id', 'is_main_office'))){
            continue;
        }
        echo "<div class='row'><div class='col-md-2'>{$e}</div><div class='col-md-10'>{$einfo[$e]}</div></div>";
    }
    echo "</div></div>";
}

function newClient() {
    global $db, $CONFIG;
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
