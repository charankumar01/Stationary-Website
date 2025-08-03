<?php
$hostname = "localhost";
$dbname = "stationary";
$username = "root";
$password = "";

// Data Source Name
$dsn = "mysql:host=$hostname;dbname=$dbname";
define('USER_IMAGES_PATH', '/admin/assets/images');
// try{
//     $dsn = "mysql:host=$hostname;dbname=$dbname;";
//     $conn = new PDO($dsn,$username,$password);
//     $conn->setattribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
//     echo "connection successful!";
// }
// catch(PDOEXCEPTION $e){
//     echo "connection field".$e->getmessage();
// }

// $conn= new mysqli($hostname,$username,$password,$dbname);
// if(!$conn)
// {
//     echo "connection field ";
// }else{
//     echo " connection successful!";
// }

// Start the session
// session_start();

$conn=mysqli_connect($hostname,$username,$password,$dbname);
if(!$conn)
{
    die("Connection failed: " . mysqli_connect_error());
}


$settings_sql = "SELECT * FROM settings";
$settings_result = $conn->query($settings_sql);

$SETTINGS = $settings_result->fetch_assoc();

?>