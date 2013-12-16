<?php
$GLOBALS = array();

//User Authentication
$GLOBALS['auth_method'] = 'local'; //local, LDAP
$GLOBALS['ldap_host'] = '';//optional
$GLOBALS['ldap_port'] = '';//optional

//SMTP Server GLOBALS
$GLOBALS['smtp_server'] = '';
$GLOBALS['smtp_port'] = '';
$GLOBALS['smtp_default_sender'] = '';
$GLOBALS['smtp_default_password'] = '';

//Database GLOBALS
$GLOBALS['db_flavor'] = 'mysqli'; //mysqli or mssql
$GLOBALS['db_database'] = 'claymore';
$GLOBALS['db_table_prefix'] = '';
$GLOBALS['db_domain_name'] = ''; //optional
$GLOBALS['db_hostname'] = '';
$GLOBALS['db_username'] = '';
$GLOBALS['db_password'] = '';


?>
