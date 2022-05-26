<?php
session_start();
ob_start();
include('db.php');
if (isset($_GET['verify_token'])) {
    $verify_token = $_GET['verify_token'];
    $verify_query = "SELECT verify_token, verify_status FROM user_list WHERE verify_token='$verify_token' LIMIT 1";
    $verify_query_run = mysqli_query($con, $verify_query);

    if (mysqli_num_rows($verify_query_run) > 0) {
        $row = mysqli_fetch_array($verify_query_run);
        if ($row['verify_status'] == "0") {
            $clicked_token = $row['verify_token'];
            $update_query = "UPDATE user_list SET verify_status='1' WHERE verify_token='$clicked_token' LIMIT 1";
            $update_query_run = mysqli_query($con, $update_query);

            if ($verify_query_run) {
                $_SESSION['status'] = "Your account has been verified succesfully.";
                echo '<script type="text/javascript">alert("Your account has been verified succesfully.")</script>';
                header("Location:login.php");
                exit(0);
            } else {
                $_SESSION['status'] = "Verification Failed.";
                echo '<script type="text/javascript">alert("Verification Failed.")</script>';
                header("Location:login.php");
                exit(0);
            }
        } else {

            $_SESSION['status'] = "Email already verified. Please Login";
            echo '<script type="text/javascript">alert("Email already verified. Please Login")</script>';
            header("Location:login.php");
            exit(0);
        }
    }
} else {

    header("Location:login.php");
    exit(0);
}
ob_end_flush();
