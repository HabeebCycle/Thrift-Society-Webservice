<?php
//error_reporting(0);
/******************************************************
------------------Required Configuration---------------
Please edit the following variables so the site can
work correctly.
******************************************************/

//We log to the DataBase
//mysql_connect('localhost', 'root', '');
//mysql_select_db('naija');
//////////////rewrite
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'contribution');

$connection = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);

//Username of the Administrator
$admin='admin';

/******************************************************
-----------------Optional Configuration----------------
******************************************************/

DEFINE('WEBSITE_URL', 'http://localhost/erudite'); //////////////rewrite
/******************************************************
----------------------Initialization-------------------
******************************************************/
include('init.php');
?>
