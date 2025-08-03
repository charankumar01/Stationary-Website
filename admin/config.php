<?php
define('ADMIN_ASSET_URL','/admin/assets/');
define('ADMIN_BASE_URL', '/admin');

$hostname = "localhost";
$dbname = "stationary";
$username = "root";
$password = "";


$conn=mysqli_connect($hostname,$username,$password,$dbname);
if(!$conn)
{
    echo "connection field ";
}
?>