<?php
//error_reporting(0);
/******************************************************
------------------Required Configuration---------------
Please edit the following variables so the site can
work correctly.
******************************************************/

define('APP_NAME', 'IVES');
define('APP_FULL_NAME', 'IVES : Accounting Management System');
define('APP_ALIAS', 'Accounting Management System');
define('APP_YEAR', date('Y',time()));

define('LOW_MED', 50000);

//////////////rewrite
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'account');

$connection = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);

//Username of the Administrator
$admin='admin';

/******************************************************
-----------------Optional Configuration----------------
******************************************************/

DEFINE('WEBSITE_URL', 'http://localhost/account'); //////////////rewrite
/******************************************************
----------------------Initialization-------------------
******************************************************/
include('init.php');
?>
