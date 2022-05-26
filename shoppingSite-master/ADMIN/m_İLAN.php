<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title> ADMİN</title>
    <link href="css/logout.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <?php
    include "db.php";
    $conn = OpenCon();
    error_reporting(0);
    if (isset($_POST['sil']) && $_SERVER['REQUEST_METHOD'] == 'POST') {

        $val = $_POST['id'];

        $sql1 = "DELETE FROM adword_list WHERE  id = $val ";
        mysqli_query($conn, $sql1);

        $sql2 = "DELETE FROM adword_image_list WHERE  adword_list_id = $val";
        mysqli_query($conn, $sql2);

        $sql3 = "DELETE FROM comment_list WHERE  adword_id= $val";
        mysqli_query($conn, $sql3);

        $sql = "DELETE FROM adword_list WHERE  id= $val";
        mysqli_query($conn, $sql);
    }
    ?>
</head>
<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-icon rotate-n-15">
                </div>
                <div class="sidebar-brand-text mx-3"> ADMIN</div>
            </a>
            <!-- Divider -->
            <hr class="sidebar-divider my-0">
            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>ADMIN PANEL</span></a>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider">
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>ÜYE İŞLEMLERİ</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">ÜYELER</h6>
                        <a class="collapse-item" href="view.php">Üyeler Tablosu</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item active">
                <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>İLANLAR</span>
                </a>
                <div id="collapseUtilities" class="collapse show" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Müşterilerin İlan Bilgileri</h6>
                        <a class="collapse-item active" href="m_İLAN.php">Verilen İlanlar</a>
                        <a class="collapse-item" href="m_İLAN_ONAY.php">Onay Bekleyen İlanlar</a>
                    </div>
                </div>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">
            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <!-- End of Sidebar -->
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                    <a href="logout.php"><i class='bx bx-log-out' id="log_out"></i></a>
                </nav>
                <!-- End of Topbar -->
                <div class="container" style="padding-top:3%">
                    <div class="row">
                        <?php
                        $urun = mysqli_query($conn, "SELECT * FROM adword_list");
                        while ($row2 = mysqli_fetch_array($urun)) { ?>
                            <div class="col-md-4 col-lg-3 col-sm-5" style="padding-top:3%">
                                <div class="card">
                                    <img src="data:image/jpeg;base64,<?php echo base64_encode($row2['image']); ?>" alt="Avatar" style="height:8rem;border-radius:3%">
                                    <div class="container">
                                        <div class="row">
                                            <h6 style="color:black;padding-left:3%"><b><?php echo $row2['head_name']; ?></b></h6>
                                        </div>
                                        <h6><?php echo $row2['price']; ?> ₺</h6>
                                        <p><?php
                                            $usr = mysqli_query($conn, "SELECT * FROM user_list");
                                            while ($row = mysqli_fetch_array($usr)) {
                                                if ($row['id'] == $row2['user_id']) {
                                                    echo $row['first_name'] . " " . $row['nick_name'];
                                                }
                                            } ?>
                                        <p>
                                            <button type="button" style="background-color:#5a5a5a;border:#5a5a5a" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal<?php echo $row2['id']; ?>">Ürünü sil</button>
                                            <!-- Modal -->
                                        <div class="modal fade" id="myModal<?php echo $row2['id']; ?>" role="dialog">
                                            <div class="modal-dialog">
                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title"><?php echo $row2['head_name']; ?> adlı ürünü silmek istediğinize emin misiniz?</h4>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Hayır</button>
                                                        <form action="" method="post" enctype="multipart/form-data">
                                                            <input type="hidden" name="id" id="subject" value="<?php echo $row2['id']; ?>">
                                                            <input type="submit" name="sil" value="Evet">
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <!-- Begin Page Content -->
                <div class="container-fluid">
                </div>
                <!-- End of Content Wrapper -->
            </div>
            <!-- End of Page Wrapper -->
            <!-- Scroll to Top Button-->
            <a class="scroll-to-top rounded" href="#page-top">
                <i class="fas fa-angle-up"></i>
            </a>
            <!-- Bootstrap core JavaScript-->
            <script src="vendor/jquery/jquery.min.js"></script>
            <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
            <!-- Core plugin JavaScript-->
            <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
            <!-- Custom scripts for all pages-->
            <script src="js/sb-admin-2.min.js"></script>
</body>
</html>