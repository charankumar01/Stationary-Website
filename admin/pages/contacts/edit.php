<?php
include('../../includes/header.php');

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $query = 'Select * from contacts where id ='.$id;
    $result = mysqli_query($conn,$query);
    if($result->num_rows >0){
        $row = $result-fetch_assoc();
    }
   
}
?>