<?php
session_start();
ob_start();
include('db.php');
$con = OpenCon();
/*Note: If this doesnt work, please check your email security settings. If your mail security level is high this is not gonna work */
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

//Load Composer's autoloader
require 'vendor/autoload.php';
function sendemail_verify($first_name, $email, $verify_token)
{
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->SMTPDebug   = 4;
    $mail->SMTPSecure = "tls";
    $mail->Port = 587;
    $mail->SMTPAuth = true;
    $mail->Host = "smtp.gmail.com";
    $mail->Username = ""; /* Enter your authentication email */
    $mail->Password = ""; /* and your password */

    $mail->setFrom('', $first_name);/* Enter your authentication email */
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = 'Aktivasyon Linki';

    $email_template = "
    <h2></h2>
    <br/><br/>
    <a href='http://localhost/lastikbank-master/lastikbank-master/verify-email.php?token=$verify_token'>TIKLAYINIZ</a>
    ";
    $mail->Body = $email_template;
    $mail->send();

}

if (isset($_POST['register_btn'])) {

    $first_name = $_POST['first_name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $city = $_POST['city'];
    $adress = $_POST['adress'];
    $password = md5($_POST['password']);
    $confirm_password = $_POST['confirm_password'];
    $verify_token = md5(rand());
    sendemail_verify("$username", "$email", "$verify_token");

}
//email exists or not

$check_email_query = "SELECT email FROM user_list WHERE email='$email' LIMIT 1";
$check_email_query_run = mysqli_query($con, $check_email_query);

if (mysqli_num_rows($check_email_query_run) > 0) {
    $_SESSION['status'] = "Bu email adresi bulunmmaktadır. Başka bir adres giriniz.";
    header("Location:login.php");
} else {
    //insert user/registered user data
    $query = "INSERT INTO user_list(username,password,first_name,email, 
         adress,city,phone,verify_token)
          values('$username','" . md5($_POST['password']) . "','$first_name','$email',
                   '$adress','$city','$phone','$verify_token')";
    $query_run = mysqli_query($con, $query);
    if ($query_run) {
        sendemail_verify("$first_name", "$email", "$verify_token");
        $_SESSION['status'] = "Üyeliğinizi tamamlamak için mail adresinize gelen linke tıklayınız.";
        header("Location:login.php");
    } else {
        $_SESSION['status'] = "Üye kayıt işleminiz başarısızdır. Lütfen tekrar deneyiniz.";
        header("Location:login.php");
    }
}
ob_end_flush();
