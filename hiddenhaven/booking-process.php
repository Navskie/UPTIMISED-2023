<?php

  include '../include/db.php';

  session_start();

  $code = $_SESSION['code'];

  $poid = $_GET['poid'];

  if ($code == '') {
    $code = $poid;
  }

  $HHcode = $_GET['HHcodes'];

  $amount_check = mysqli_query($connect, "SELECT * FROM haven_product WHERE product_code = '$HHcode'");
  $amount_check_qry = mysqli_fetch_array($amount_check);

  if (isset($_POST['process'])) {
    $time = $_POST['timeslot'];
    // echo '<br>';
    $pax = $_POST['totalpax'];
    // echo '<br>';
    $fname1 = $_POST['fname1'];
    $days = $_POST['days'];
    // echo '<br>';
    $contact = $_POST['contact'];
    
    if ($days == 'Weekdays' && $time == 'Sunrise - Daytime (9am to 6pm)') {
      $diff_date = $_SESSION['diff'] + 1;
      $amount = 4200 * $diff_date;

    } elseif (($days == 'Weekends' && $time == 'Sunrise - Daytime (9am to 6pm)')) {
      $diff_date = $_SESSION['diff'] + 1;
      $amount = 47000 * $diff_date;

    } elseif (($days == 'Weekdays' && $time == 'Sunset - Nighttime (9pm to 6am)')) {
      $diff_date = $_SESSION['diff'] + 1;
      $amount = 47000 * $diff_date;

    } elseif (($days == 'Weekends' && $time == 'Sunset - Nighttime (9pm to 6am)')) {
      $diff_date = $_SESSION['diff'] + 1;
      $amount = 52000 * $diff_date;

    } elseif (($days == 'Weekdays' && $time == 'Full Stay - Daytime (9am to 7am)')) {
      $diff_date = $_SESSION['diff'];
      $amount = 6500 * $diff_date;

    } elseif (($days == 'Weekends' && $time == 'Full Stay - Daytime (9am to 7am)')) {
      $diff_date = $_SESSION['diff'];
      $amount = 7500 * $diff_date;

    } elseif (($days == 'Weekdays' && $time == 'Full Stay - Nighttime (9pm to 7pm)')) {
      $diff_date = $_SESSION['diff'];
      $amount = 6500 * $diff_date;

    } elseif (($days == 'Weekends' && $time == 'Full Stay - Nighttime (9pm to 7pm)')) {
      $diff_date = $_SESSION['diff'];
      $amount = 7500 * $diff_date;

    }

    if ($pax >= 5) {
      $sobra = $pax - 4;
      $subtotal = $sobra * 300 * $diff_date;
      $amount = $amount + $subtotal;
    }

    if ($pax > 10) {
      echo '<script>alert("You have exceeded the villa capacity.");window.location.href = "booking.php?HHCode='.$HHcode.'";</script>';
    } else {
      $insert_name1 = "INSERT INTO haven_name (hh_code, pangalan) VALUES ('$poid', '$fname1')";
      $insert_name1_qry = mysqli_query($connect, $insert_name1);

      $details = "INSERT INTO haven_details (
        details_code,
        details_ref,
        details_time,
        details_days,
        details_pax,
        details_amount,
        details_contact
      ) VALUES (
        '$code',
        '$poid',
        '$time',
        '$days',
        '$pax',
        '$amount',
        '$contact'
      )";
      $details_qry = mysqli_query($connect, $details);

      // header('Location: booking.php?HHCode='.$HHcode.'');
      echo '<script>alert("Information have been save successfully.");window.location.href = "booking.php?HHCode='.$HHcode.'";</script>';
    }

  }

  if (isset($_POST['update'])) {
    $time = $_POST['timeslot'];
    // echo '<br>';
    $pax = $_POST['totalpax'];
    // echo '<br>';
    $fname1 = $_POST['fname1'];
    $days = $_POST['days'];
    // echo '<br>';
    $contact = $_POST['contact'];
    
        
    if ($days == 'Weekdays' && $time == 'Sunrise - Daytime (9am to 6pm)') {
      $diff_date = $_SESSION['diff'] + 1;
      $amount = 4200 * $diff_date;

    } elseif (($days == 'Weekends' && $time == 'Sunrise - Daytime (9am to 6pm)')) {
      $diff_date = $_SESSION['diff'] + 1;
      $amount = 47000 * $diff_date;

    } elseif (($days == 'Weekdays' && $time == 'Sunset - Nighttime (9pm to 6am)')) {
      $diff_date = $_SESSION['diff'] + 1;
      $amount = 47000 * $diff_date;

    } elseif (($days == 'Weekends' && $time == 'Sunset - Nighttime (9pm to 6am)')) {
      $diff_date = $_SESSION['diff'] + 1;
      $amount = 52000 * $diff_date;

    } elseif (($days == 'Weekdays' && $time == 'Full Stay - Daytime (9am to 7am)')) {
      $diff_date = $_SESSION['diff'];
      $amount = 6500 * $diff_date;

    } elseif (($days == 'Weekends' && $time == 'Full Stay - Daytime (9am to 7am)')) {
      $diff_date = $_SESSION['diff'];
      $amount = 7500 * $diff_date;

    } elseif (($days == 'Weekdays' && $time == 'Full Stay - Nighttime (9pm to 7pm)')) {
      $diff_date = $_SESSION['diff'];
      $amount = 6500 * $diff_date;

    } elseif (($days == 'Weekends' && $time == 'Full Stay - Nighttime (9pm to 7pm)')) {
      $diff_date = $_SESSION['diff'];
      $amount = 7500 * $diff_date;

    }

    // echo $amount;

    if ($pax >= 5) {
      $sobra = $pax - 4;
      $subtotal = $sobra * 300;
      $amount = $amount + $subtotal;
    }

    // echo $amount;

    if ($pax > 10) {
      echo '<script>alert("You have exceeded the villa capacity.");window.location.href = "booking.php?HHCode='.$HHcode.'";</script>';
    } else {
      $insert_name1 = mysqli_query($connect, "UPDATE haven_name SET pangalan = '$fname1' WHERE hh_code = '$poid'");

      $details = "UPDATE haven_details SET
        details_time = '$time',
        details_pax = '$pax',
        details_days = '$days',
        details_amount = '$amount',
        details_contact = '$contact'
      WHERE 
        details_ref = '$poid'
      ";
       $meeee = mysqli_query($connect, $details);
    }
    header('Location: booking.php?HHCode='.$HHcode.'');
  }

  if (isset($_POST['book'])) {
    $img_name = $_FILES['file']['name'];
    $img_size = $_FILES['file']['size'];
    $img_tmp = $_FILES['file']['tmp_name'];
    $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
    // echo ($img_ex);
    $img_ex_lc = strtolower($img_ex);

    $allow_ex = array("jpg", "jpeg", "png", "gif");

    $new_name = $poid.'.'.$img_ex_lc;
    $img_path_sa_buhay_niya = 'assets/images/'.$new_name;
    move_uploaded_file($img_tmp, $img_path_sa_buhay_niya);

    $session_date1 = $_SESSION['date1banene'];
    $session_date2 = $_SESSION['date2banene'];
    $datenow = date('m-d-Y');

    // booking
    $update_booking = mysqli_query($connect, "INSERT INTO haven_booking (
      booking_ref,
      payment,
      booking_status,
      booking_start,
      booking_end,
      booking_date,
      booking_remarks
    ) VALUES (
      '$poid',
      '$new_name',
      'Pending',
      '$session_date1',
      '$session_date2',
      '$datenow',
      'Ano meron'
    )");

    // date
    $update_date = mysqli_query($connect, "UPDATE haven_date SET book_remarks = 'Not Available' WHERE book_poid = '$poid'");

    $get_total_amount = mysqli_query($connect, "SELECT * FROM haven_details WHERE details_ref = '$poid'");
    $get_total_fetch = mysqli_fetch_array($get_total_amount);

    $pax = $get_total_fetch['details_pax'];
    
    if ($pax >= 5) {
      $result_pax = $pax - 4;
      $result_300 = $result_pax * 300;
      $amount_pax = $get_total_fetch['details_amount'] + $result_300;

      $update_date = mysqli_query($connect, "UPDATE haven_details SET details_amount = '$amount_pax' WHERE details_ref = '$poid'");
    }

    $get_haven = mysqli_query($connect, "SELECT * FROM upti_users WHERE users_code = '$code'");
    $haven_fetch = mysqli_fetch_array($get_haven);

    $new_count = $haven_fetch['users_haven'] + 1;
    // update count 
    $update_count = mysqli_query($connect, "UPDATE upti_users SET users_haven = '$new_count' WHERE users_code = '$code'");

    unset($_SESSION['date1banene']);
    unset($_SESSION['date2banene']);
    unset($_SESSION['diff']);
    $_SESSION['date1banene'] = '';
    $_SESSION['date2banene'] = '';
    $_SESSION['diff'] = '';

    if  ($_SESSION['guest'] != 'Guest') {

    echo '<script>alert("Booking Successful! Please find the booking details in your dashboard.");window.location.href = "../system/mybooking.php";</script>';

    } else {

    header('location: reference.php?id='.$poid.'');

    }

  }

?>