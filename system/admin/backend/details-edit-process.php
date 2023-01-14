<?php 
  include '../database/dbconn.php';

  $id = $_GET['id'];

  if (isset($_POST['details-edit'])) {
    $title = $_POST['title'];

    $desc = $_POST['desc'];
    $weekdays = $_POST['weekdays'];
    $weekends = $_POST['weekends'];
    $status = $_POST['status'];

    if ($title == '' || $desc == '' || $weekdays == '' || $weekends == '' || $status == '') {
      echo '<script>alert("All fields are required");window.location.href = "../admin-details.php";</script>';
    } else {
      $update_style = mysqli_query($connect, "UPDATE haven_product
      SET 
      product_title = '$title', product_desc = '$desc', product_weekdays = '$weekdays', product_weekends = '$weekends', product_status = '$status', product_updated = '$timedate'
      WHERE
      product_code = '$id'
      ");
      echo '<script>window.location.href = "../admin-details.php";</script>';
    }

  }
?>