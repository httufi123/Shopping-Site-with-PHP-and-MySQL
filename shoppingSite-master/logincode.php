<?php
session_start();
include "db.php";
$conn = OpenCon();
$errors = array();
error_reporting(0);
$user_id = "aşağıdan buraya değer veremiyorum";
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $door = true;
    if ($email != null && $password != null) {
        $res = mysqli_query($conn, "SELECT * FROM user_list");
        while ($row = mysqli_fetch_array($res)) {
            if ($email == $row['email'] && $password == $row['password']) {
                $door = false;
                $_SESSION["user_id"] = $row['id'];
                if ($row['state'] == 0 || $row['state'] == 1) {
                    header("Location:userx/anasayfa.php");
                } else if ($row['state'] == 2) {
                    header("Location:ADMIN/index.php");
                }
            }
        }
        if ($door) {
            $_SESSION['status'] = "Mail adresiniz veya şifreniz hatalıdır.Tekrar deneyiniz.";
            header("Location:login.php"); //burda öyle bi kullanıcı yok
            exit(0);
        }
    } else {
        $_SESSION['status'] = "Lütfen boş bırakmayınız.";
        header("Location:login.php"); //burada boş kişi girmsin
        exit(0);
    }
}
