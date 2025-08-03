<?php
include ('./config.php');

$query = "Select * from contact";
$result = mysqli_query($conn ,$query)
?>
<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Email</th>
      <th scope="col">adress</th>
      <th scope="col">service</th>
      <th scope="col">Message</th>
      <th scope="col">image</th>

    </tr>
  </thead>
  <tbody>
    <?php
    if($result-> num_rows > 0)
    {
    while($row = $result->fetch_assoc())
    {  
    ?>
    <tr>
      <th scope="row"><?= $row['id']?></th>
      <td><?= $row['name']?></td>
      <td><?= $row['email']?></td>
      <td><?= $row['adress']?></td>
      <td><?= $row['service']?></td>
      <td><?= $row['message']?></td>
      <td><?= $row['image']?></td>
      <td>
        <a href="edit.php?id=<?php echo $row['id'] ?>" class="btn btn-primary">Edit</a>
        <a href="delete.php?id=<?php echo $row['id'] ?>" class="btn btn-danger">delete</a>
      </td>
    </tr>
    <?php
         }
    }
    ?>
  </tbody>
</table>