<?php
include "db.php";
$conn = OpenCon();
$sql = "SELECT id,username,password,first_name,email,
adress,city,country,phone,state FROM user_list ";
$result = $conn->query($sql);
?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>/ADMIN</title>
    <!-- Custom fonts for this template-->
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link href="css/logout.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/to_do.css" rel="stylesheet">
    <script>
        src = "Day\Day\ADMIN\js\todo.js"
    </script>
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>
<?php

if (isset($_POST['sil']) && $_SERVER['REQUEST_METHOD'] == 'POST') {

    $user_id = $_POST['id'];

    $sql1 = "DELETE FROM adword_list WHERE user_id  =  $user_id";
    mysqli_query($conn, $sql1);

    $sql2 = "DELETE FROM adword_image_list WHERE user_id  =  $user_id";
    mysqli_query($conn, $sql2);

    $sql = "DELETE FROM user_list WHERE id  =  $user_id";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo '<script language="javascript">';
        echo 'alert("Üye silinmiştir")';  //not showing an alert box.
        echo '</script>';
    } else {
        echo '<script language="javascript">';
        echo 'alert("Üye silinme başarısız!")';  //not showing an alert box.
        echo '</script>';
    }
    header("Refresh:0");
}

?>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-text mx-3"> Admin</div>
            </a>
            <!-- Divider -->
            <hr class="sidebar-divider my-0">
            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>ADMİN PANEL</span></a>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider">
            <!-- Heading -->
            <div class="sidebar-heading">
            </div>
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>ÜYE İŞLEMLERİ</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Üyeler</h6>
                        <a class="collapse-item" href="view.php">Üyeler Tablosu</a>
                    </div>
                </div>
            </li>
            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>İLANLAR</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Müşterilerin İlan Bilgileri</h6>
                        <a class="collapse-item" href="m_İLAN.php">Verilen İlanlar</a>
                        <a class="collapse-item" href="m_İLAN_ONAY.php">Onay Bekleyen İlanlar</a>
                    </div>
                </div>
            </li>
            <div class="sidebar-heading">
            </div>

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
                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- End of Topbar -->

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="container-fluid">
                            <div class="row" style="overflow-x:auto;">
                                <div class="col-6 col-sm-6 mb-6">

                                    <h2>ÜYELER</h2>
                                    <table class="table">

                                        <head>
                                            <tr>
                                                <th>ID</th>
                                                <th>Kullanıcı Adı</th>
                                                <th>Şifre</th>
                                                <th>Adı</th>
                                                <th>Email</th>
                                                <th>Adres</th>
                                                <th>Şehir</th>
                                                <th>Ülke</th>
                                                <th>Telefon</th>
                                                <th>State</th>
                                            </tr>
                                            </thread>
                                </div>
                            </div>
                            </tbody>
                            <?php
                            if ($result !== false && $result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                            ?>
                                    <tr>
                                        <td><?php echo $row['id']; ?></td>
                                        <td><?php echo $row['username']; ?></td>
                                        <td><?php echo $row['password']; ?></td>
                                        <td><?php echo $row['first_name']; ?></td>
                                        <td><?php echo $row['email']; ?></td>
                                        <td><?php echo $row['adress']; ?></td>
                                        <td><?php echo $row['city']; ?></td>
                                        <td><?php echo $row['country']; ?></td>
                                        <td><?php echo $row['phone']; ?></td>
                                        <td><?php echo $row['state']; ?></td>
                                        <td>

                                            <button href="#" style="background-color:#8396E5;color:white;border:1px solid #8396E5" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal<?php echo $row['id']; ?>">Üye sil</button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="myModal<?php echo $row['id']; ?>" role="dialog">
                                                <div class="modal-dialog">
                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title"><?php echo $row['first_name']; ?> adlı kullanıcıyı silmek istediğinize emin misiniz?</h4>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" style="display: inline;" class="btn btn-default" data-dismiss="modal">Hayır</button>
                                                            <form action="" method="post" enctype="multipart/form-data" style="display: inline;">
                                                                <input type="hidden" name="id" id="subject" value="<?php echo $row['id']; ?>">
                                                                <input type="submit" class="btn btn-default" name="sil" value="Evet">
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </td>
                                    </tr>
                            <?php    }
                            }
                            ?>
                            </tbody>
                            </table>
                        </div>
                        <!-- Bootstrap core JavaScript-->
                        <script src="vendor/jquery/jquery.min.js"></script>
                        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

                        <!-- Core plugin JavaScript-->
                        <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

                        <!-- Custom scripts for all pages-->
                        <script src="js/sb-admin-2.min.js"></script>

                        <!-- Page level plugins -->
                        <script src="vendor/chart.js/Chart.min.js"></script>

                        <!-- Page level custom scripts -->
                        <script src="js/demo/chart-area-demo.js"></script>
                        <script src="js/demo/chart-pie-demo.js"></script>
                    </div>
                </section>
            </div>
        </div>
    </div>
</body>

</html>