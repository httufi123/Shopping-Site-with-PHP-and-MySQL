<?php include "db.php";
?>

<?php include "header.php" ?>
<!-- Product Section Begin -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>LASTIKBANK</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">
    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>
</head>

<body>
    <section class="product spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="section-title product__discount__title">
                        <?php
                        error_reporting(0);
                        $baslik = "Ürünler";
                        ?>
                        <h2 style="font-family: Serif"><?php echo $baslik; ?></h2>
                    </div>
                    <div class="filter__item">
                    </div>
                    <div class="row">
                        <?php
                        $query = mysqli_query($conn, "SELECT * FROM adword_list Where head_name LIKE '%{$_POST['search']}%'");
                        while ($row2 = mysqli_fetch_array($query)) {
                            $image = $row2['image'];
                            $head_name = $row2['head_name'];
                            $price = $row2['price'];
                            $id = $row2['id'];
                        ?>
                            <a href="product.php?ProductID=<?php echo $id; ?>">
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="product__item">
                                        <div class="product__item__pic" img src="data:image/jpeg;base64<?php echo $image; ?>.jpg">

                                        </div>
                                        <div class="product__item__text">
                                            <h6><a href="#"><?php echo $head_name; ?></a></h6>
                                            <h5><?php echo $price; ?> ₺</h5>
                                        </div>
                                    </div>

                                </div>
                            </a>

                        <?php   }  ?>
                    </div>

                </div>
            </div>
        </div>
    </section>
</body>
<?php include "footer.php" ?>