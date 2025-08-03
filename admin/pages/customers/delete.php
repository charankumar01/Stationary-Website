<?php
include('../../config.php');

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $query = 'Delete from customers where id ='.$id;
    $result = mysqli_query($conn,$query);
    if($result){
        echo "<script>window.location.href='index.php'</script>";
    }
    else{
        echo "something went wrong!";
    }
}
?>