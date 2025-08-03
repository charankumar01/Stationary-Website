<?php
include('../include/header.php');
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $query = "Delete from contact where id = ".$id;
    $result = mysqli_query($conn,$query);

    if($result){
        // echo "record deleted successfully!
            echo"<script>window.location.href='records.php'</script>";
    }else{
        echo "rechord not deleted!";
    }
}
?>