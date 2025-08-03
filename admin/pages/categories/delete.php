<?php
include __DIR__.'/../../config.php';

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $query = "DELETE FROM `categories` WHERE id =".$id;
   
    $result = mysqli_query($conn,$query);
    if($result){
        echo "<script>window.location.href='index.php'</script>";
    }
    else{
        echo "something went wrong!";
    }
}
?>