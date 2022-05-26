<?php
session_start();
ob_start();
if (!isset($_SESSION['authenticated'])) {
    $_SESSION['status'] = "Please Login to access user dashboard";
    header("Location:login.php");
    exit(0);
}
ob_end_flush();
