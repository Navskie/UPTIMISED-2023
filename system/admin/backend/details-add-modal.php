<?php 
  // include './database/dbconn.php';

  $count = mysqli_query($connect, "SELECT COUNT(*) AS counts FROM haven_product");
  $count_fetch = mysqli_fetch_array($count);
  $counts = $count_fetch['counts'];

  $year = date('y');
  $month = date('m');

  $codes = "HR".$year.$month.$counts;

  if (isset($_POST['details-add'])) {
    $title = $_POST['title'];
    // $code = $_POST['havencode'];
    $desc = $_POST['desc'];
    $weekdays = $_POST['weekdays'];
    $weekends = $_POST['weekends'];
    $status = $_POST['status'];

    if ($title == '' || $desc == '' || $weekdays == '' || $weekends == '' || $status == '' || $codes == '') {
      echo '<script>alert("All fields are required");window.location.href = "admin-details.php";</script>';
    } else {
      $insert_style = mysqli_query($connect, "INSERT INTO haven_product
      (product_title, product_desc, product_weekdays, product_weekends, product_code, product_status, product_updated)
      VALUES
      ('$title', '$desc', '$weekdays', '$weekends', '$codes', '$status', '$timedate')
      ");
      echo '<script>window.location.href = "admin-details.php";</script>';
    }

  }
?>
<!-- animation modal Dialogs start -->
<div class="md-modal md-effect-5" id="details-1">
    <form action="admin-details.php" method="post">
    <div class="md-content">
        <h3>Villa Style</h3>
        <div>
            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  <label>Title</label>
                  <input type="text" name="title" class="form-control" required autocomplete="OFF">
                </div>
              </div>

              <div class="col-6">
                <div class="form-group">
                  <label>Code</label>
                  <input disabled type="text" value="<?php echo $codes ?>" name="havencode" class="form-control" required autocomplete="OFF">
                </div>
              </div>

              <div class="col-12">
                <div class="form-group">
                  <label>Description</label>
                  <input type="text" name="desc" class="form-control" required autocomplete="OFF">
                </div>
              </div>

              <div class="col-3">
                <div class="form-group">
                  <label>Weekdays</label>
                  <input type="number" name="weekdays" min="1" class="form-control" required autocomplete="OFF">
                </div>
              </div>

              <div class="col-3">
                <div class="form-group">
                  <label>Weekends</label>
                  <input type="number" min="1" name="weekends" class="form-control" required autocomplete="OFF">
                </div>
              </div>

              <div class="col-6">
                <div class="form-group">
                  <label>Status</label>
                  <select name="status" class="form-control">
                    <option value="">Select Status</option>
                    <option value="Active">Active</option>
                    <option value="Not Active">Not Active</option>
                  </select>
                </div>
              </div>
            </div>
            <button type="button" class="float-left btn btn-danger waves-effect md-close">Close</button>
            <button type="submit" class="float-right btn btn-success" name="details-add">Submit</button>
            <br>
        </div>
        </form>
    </div>
</div>