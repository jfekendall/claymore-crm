<?php
$GLOBALS = array();

//Basics
$GLOBALS['template'] = 'default'; //folder must be in /templates

//User Authentication
$GLOBALS['auth_method'] = 'local'; //local, ldap
$GLOBALS['auth_expire_time'] = '3600';
$GLOBALS['auth_password_hash_algo'] = 'sha512'; //See http://www.php.net/manual/en/function.hash-algos.php for supported algorythms
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
$GLOBALS['db_hostname'] = 'localhost';
$GLOBALS['db_username'] = 'root';
$GLOBALS['db_password'] = 'asdf'; //It's the dev machine. Don't judge me *cries in a corner*


?>
