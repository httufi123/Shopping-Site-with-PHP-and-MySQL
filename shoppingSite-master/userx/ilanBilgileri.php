<?php
include "db.php";
include "header.php";
$conn = OpenCon();
error_reporting(0);
?>

<?php
session_start();
$user_id = $_SESSION["user_id"];


$usr = mysqli_query($conn, "SELECT * FROM user_list WHERE id = $user_id");
while ($row = mysqli_fetch_array($usr)) {
    $f_name = $row['first_name'];
    $n_name = $row['nick_name'];
    $username = $row['username'];
    $email = $row['email'];
    $tel = $row['phone'];
    $adres = $row['adress'];
    $city = $row['city'];
    $ilce = $row['ilce'];
    $ulke = $row['country'];
}

if (isset($_POST['sil']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $val = $_POST['id'];

    $sql1 = "DELETE FROM adword_image_list WHERE  adword_list_id= $val AND user_id= $user_id";
    mysqli_query($conn, $sql1);

    $sql2 = "DELETE FROM adword_feed WHERE  adword_list_id= $val";
    mysqli_query($conn, $sql2);

    $sql3 = "DELETE FROM comment_list WHERE  adword_id= $val";
    mysqli_query($conn, $sql3);

    $sql = "DELETE FROM adword_list WHERE  id= $val";
    mysqli_query($conn, $sql);
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title> </title>
    <link rel="stylesheet" href="style.css">
    <title>/</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/Slider.css" rel="stylesheet">

    <!--slider linkleri-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="style.css">
    <!-- Boxicons CDN Link -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <scrip src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js">
        </script>
        <!-- Boxicons CDN Link -->
        <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            /*
    DEMO STYLE
*/

            @import "https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700";

            body {
                font-family: 'Poppins', sans-serif;
                background: #fafafa;


            }

            .container,
            .navbar-static-top .container,
            .navbar-fixed-top .container,
            .navbar-fixed-bottom .container {
                width: 100%;
            }

            p {
                font-family: 'Poppins', sans-serif;
                font-size: 1.1em;
                font-weight: 300;
                line-height: 1.7em;
                color: #999;
            }

            div {
                word-wrap: break-word;
            }

            /* ---------------------------------------------------
    CONTENT STYLE
----------------------------------------------------- */
            .modal-backdrop {
                position: fixed;
                top: 0;
                right: 0;
                bottom: 0;
                left: 0;
                z-index: 0;
                background-color: #000;
            }

            #content {
                width: 100%;
                padding: 20px;
                min-height: 100vh;
                transition: all 0.3s;
            }

            /* ---------------------------------------------------
    MEDIAQUERIES
----------------------------------------------------- */


            .card {
                box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
                transition: 0.3s;
                width: 100%;
            }

            .card:hover {
                box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
            }

            .container {
                padding: 2px 16px;
            }


            #img-upload {
                width: 200px;
            }
        </style>

        <style>
            body {
                background-color: #f5f5f5;
            }

            .title {

                margin-bottom: 50px;
                text-transform: uppercase;
            }

            .card-block {
                font-size: 1em;
                position: relative;
                margin: 0;
                padding: 1em;
                border: none;
                border-top: 1px solid rgba(34, 36, 38, .1);
                box-shadow: none;

            }

            .card {
                font-size: 1em;
                overflow: hidden;
                padding: 5;
                border: none;
                border-radius: .28571429rem;
                box-shadow: 0 1px 3px 0 #d4d4d5, 0 0 0 1px #d4d4d5;
            }

            .carousel-indicators li {
                border-radius: 12px;
                width: 12px;
                height: 12px;
                background-color: #404040;
            }

            .carousel-indicators li {
                border-radius: 12px;
                width: 12px;
                height: 12px;
                background-color: #404040;
            }

            .carousel-indicators .active {
                background-color: white;
                max-width: 12px;
                margin: 0 3px;
                height: 12px;
            }



            .btn {
                margin-top: auto;
            }


            a:hover,
            a:focus {
                text-decoration: none;
                outline: none;
            }
        </style>
</head>

<body>
    <section class="home-section">
    <div style="text-align: center">
            <h3>Verdiğiniz İlanlar</h3>
            <hr style="width: 80%;margin-left:10%;border: 1px solid white">
        </div>
        <div class="container">
            <div class="row" style="padding-left: 6%;padding-right:6%">

                <?php $door = true;
                $urun = mysqli_query($conn, "SELECT * FROM adword_list WHERE user_id = $user_id");
                while ($row2 = mysqli_fetch_array($urun)) {
                    if ($door) {
                        $door = false; ?>

                        <div class="card float-left" style="background-color: #f2f2f2;">
                            <div class="row">

                                <div class="col-sm-7">
                                    <div class="card-block">
                                        <!--           <h4 class="card-title">Small card</h4> -->
                                        <p><?php echo $row2['head_name']; ?></p>
                                        <p><?php echo $row2['price']; ?> ₺</p> <br>
                                        <a href="update_urun.php?urun_id=<?php echo $row2['id']; ?>" style="background-color:#8396E5;color:white;border:1px solid #8396E5" class="btn btn-primary btn-sm">Güncelle</a>
                                        <button href="#" style="background-color:#8396E5;color:white;border:1px solid #8396E5" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal<?php echo $row2['id']; ?>">İlanı sil</button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="myModal<?php echo $row2['id']; ?>" role="dialog">
                                            <div class="modal-dialog">
                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title"><?php echo $row2['head_name']; ?> ürünü silmek istediğinize emin misiniz?</h4>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" style="display: inline;" class="btn btn-default" data-dismiss="modal">Hayır</button>
                                                        <form action="" method="post" enctype="multipart/form-data" style="display: inline;">
                                                            <input type="hidden" name="id" id="subject" value="<?php echo $row2['id']; ?>">
                                                            <input type="submit" class="btn btn-default" name="sil" value="Evet">
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-sm-5">
                                    <img class="d-block w-100" style="width:15rem;height:15rem" src="data:image/jpeg;base64,<?php echo base64_encode($row2['image']); ?>" alt="Avatar">
                                </div>
                            </div>
                        </div>

                    <?php } else {
                        $door = true; ?>
                        <div class="card float-right" style="background-color:#f2f2f2">
                            <div class="row">
                                <div class="col-sm-5">
                                    <img class="d-block w-100" style="width:15rem;height:15rem" src="data:image/jpeg;base64,<?php echo base64_encode($row2['image']); ?>" alt="Avatar">
                                </div>
                                <div class="col-sm-7">
                                    <div class="card-block">
                                        <!--<h4 class="card-title">Small card</h4> -->
                                        <p><?php echo $row2['head_name']; ?></p>
                                        <p><?php echo $row2['price']; ?>₺</p><br>
                                        <a href="update_urun.php?urun_id=<?php echo $row2['id']; ?>&user_id=<?php echo $user_id; ?>" style="background-color:#8396E5;color:white;border:1px solid #8396E5" class="btn btn-primary btn-sm">Güncelle</a>
                                        <button href="#" style="background-color:#8396E5;color:white;border:1px solid #8396E5" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal<?php echo $row2['id']; ?>">İlanı sil</button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="myModal<?php echo $row2['id']; ?>" role="dialog">
                                            <div class="modal-dialog">
                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title"><?php echo $row2['head_name']; ?> ürünü silmek istediğinize emin misiniz?</h4>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" style="display: inline;" class="btn btn-default" data-dismiss="modal">Hayır</button>
                                                        <form action="" method="post" enctype="multipart/form-data" style="display: inline;">
                                                            <input type="hidden" name="id" id="subject" value="<?php echo $row2['id']; ?>">
                                                            <input type="submit" class="btn btn-default" name="sil" value="Evet">
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php  }
                } ?>

            </div>
        </div>


        <div style="text-align: center">
            <h3>Onay Bekleyen İlanlar</h3>
            <hr style="width: 80%;margin-left:10%;border: 1px solid white">
        </div>
        <div class="container">
            <div class="row" style="padding-left: 6%;padding-right:6%">

                <?php $door = true;
                $urun = mysqli_query($conn, "SELECT * FROM check_adword_list WHERE user_id = $user_id");
                while ($row2 = mysqli_fetch_array($urun)) {
                    if ($door) {
                        $door = false; ?>

                        <div class="card float-left" style="background-color: #f2f2f2;">
                            <div class="row">

                                <div class="col-sm-7">
                                    <div class="card-block">
                                        <!--           <h4 class="card-title">Small card</h4> -->
                                        <p><?php echo $row2['head_name']; ?></p>
                                        <p><?php echo $row2['price']; ?> ₺</p> <br>
                                        <a href="update_urun.php?urun_id=<?php echo $row2['id']; ?>" style="background-color:#8396E5;color:white;border:1px solid #8396E5" class="btn btn-primary btn-sm">Güncelle</a>
                                        <button href="#" style="background-color:#8396E5;color:white;border:1px solid #8396E5" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal<?php echo $row2['id']; ?>">İlanı sil</button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="myModal<?php echo $row2['id']; ?>" role="dialog">
                                            <div class="modal-dialog">
                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title"><?php echo $row2['head_name']; ?> ürünü silmek istediğinize emin misiniz?</h4>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" style="display: inline;" class="btn btn-default" data-dismiss="modal">Hayır</button>
                                                        <form action="" method="post" enctype="multipart/form-data" style="display: inline;">
                                                            <input type="hidden" name="id" id="subject" value="<?php echo $row2['id']; ?>">
                                                            <input type="submit" class="btn btn-default" name="sil" value="Evet">
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-sm-5">
                                    <img class="d-block w-100" style="width:15rem;height:15rem" src="data:image/jpeg;base64,<?php echo base64_encode($row2['image']); ?>" alt="Avatar">
                                </div>
                            </div>
                        </div>

                    <?php } else {
                        $door = true; ?>
                        <div class="card float-right" style="background-color:#f2f2f2">
                            <div class="row">
                                <div class="col-sm-5">
                                    <img class="d-block w-100" style="width:15rem;height:15rem" src="data:image/jpeg;base64,<?php echo base64_encode($row2['image']); ?>" alt="Avatar">
                                </div>
                                <div class="col-sm-7">
                                    <div class="card-block">
                                        <!--<h4 class="card-title">Small card</h4> -->
                                        <p><?php echo $row2['head_name']; ?></p>
                                        <p><?php echo $row2['price']; ?>₺</p><br>
                                        <a href="update_urun.php?urun_id=<?php echo $row2['id']; ?>&user_id=<?php echo $user_id; ?>" style="background-color:#8396E5;color:white;border:1px solid #8396E5" class="btn btn-primary btn-sm">Güncelle</a>
                                        <button href="#" style="background-color:#8396E5;color:white;border:1px solid #8396E5" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal<?php echo $row2['id']; ?>">İlanı sil</button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="myModal<?php echo $row2['id']; ?>" role="dialog">
                                            <div class="modal-dialog">
                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title"><?php echo $row2['head_name']; ?> ürünü silmek istediğinize emin misiniz?</h4>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" style="display: inline;" class="btn btn-default" data-dismiss="modal">Hayır</button>
                                                        <form action="" method="post" enctype="multipart/form-data" style="display: inline;">
                                                            <input type="hidden" name="id" id="subject" value="<?php echo $row2['id']; ?>">
                                                            <input type="submit" class="btn btn-default" name="sil" value="Evet">
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php  }
                } ?>

            </div>
        </div>
    </section>

    <script src="script.js"></script>

</body>

</html>