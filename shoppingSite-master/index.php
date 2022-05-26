<?php include "header.php";
?>
<?php
include "db.php";
$conn = OpenCon();
error_reporting(0);
?>
<link rel="stylesheet" href="assets/css/w3.css">
<link href='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css' rel='stylesheet'>
<script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
<script type='text/javascript' src='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js'></script>
<link rel="stylesheet" href="assets/css/a.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.8.2/css/lightbox.min.css">
<style>
  .mySlides {
    display: none;
  }

  .categories__item {
    height: 270px;
    position: relative;
  }

  .resimKapsayici {
    position: relative
  }

  .resimYazisi {
    position: absolute;
    padding-left: 25%;
    top: 70%;
    background-color: white;
    color: black;
    width: 100%;
    padding-top: 3%;
    height: auto;
  }
</style>

<body>
  <div class="container-fluidd">
    <div class="w3-content w3-section" style="padding: 0px;margin:0px">
      <img class="mySlides" src="assets/img/homepage.jpg" style="width:100%">
      <img class="mySlides" src="assets/img/lastik/b2.jpg" style="width:100%">
      <img class="mySlides" src="assets/img/c3.jpg" style="width:100%">
    </div>
  </div>

  <script>
    var myIndex = 0;
    carousel();

    function carousel() {
      var i;
      var x = document.getElementsByClassName("mySlides");
      for (i = 0; i < x.length; i++) {
        x[i].style.display = "none";
      }
      myIndex++;
      if (myIndex > x.length) {
        myIndex = 1
      }
      x[myIndex - 1].style.display = "block";
      setTimeout(carousel, 3000); // Change image every 2 seconds
    }
  </script>

  <br> <br>
  <!-- Categories Section Begin -->
  <section class="categories">
    <div class="container-fluid">
      <div class="row" style="padding-left: 4%;padding-right:4%">

        <div class="col-lg-4">
          <div class="categories__item resimKapsayici"><a href="productlist.php?Grup=Lastik">
              <img style="width: 100%;height:100%" src="assets/img/lastik/mic.jpg" alt="">
              <div class="resimYazisi">
                <h3> Lastik Çeşitleri </h3>
              </div>
            </a>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="categories__item resimKapsayici"><a href="productlist.php?Grup=Akü">
              <img style="width: 100%;height:100%" src="assets/img/lastik/b2.jpg" alt="">
              <div class="resimYazisi">
                <h3> Akü Çeşitleri</h3>
              </div>
            </a>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="categories__item resimKapsayici"><a href="productlist.php?Grup=Jant">
              <img style="width: 100%;height:100%" src="assets/img/lastik/jant3.jpg" alt="">
              <div class="resimYazisi">
                <h3> Jant Çeşitleri </h3>
              </div>
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Categories Section End -->
  <!-- ======= Portfolio Section ======= -->
  <section id="portfolio" class="portfolio">
    <div class="container-fluid" >
      <div class="section-title">
        <h3>Anasayfa Vitrini</h3>
      </div>
      <div class="container" style="object-fit: cover">
        <div class="row" style="object-fit: cover" >
          <?php
          $urun = mysqli_query($conn, "SELECT * FROM adword_list");
          while ($row2 = mysqli_fetch_array($urun)) { ?>
            <div class="col-md-4 col-lg-2 col-sm-5" style="padding-top:1%">
                <a href="product.php?ProductID=
                <?php echo $row2['id']; ?>">
                <img style='height: 70%; width: 70%; object-fit: cover' 
                src="data:image/jpeg;base64,
                <?php echo base64_encode($row2['image']); ?>" alt="Avatar" style="height:8rem"></a>
                <div class="container">
                  <div class="row" style="object-fit: cover">
                    <a href="product.php?ProductID=<?php echo $row2['id']; ?>">
                    <h6 style="color:black;padding-right:8% object-fit: cover"><b><?php echo $row2['head_name']; ?></b></h6>
                    </a>
                  </div>
                    <!-- Modal -->
                  <div class="modal fade" id="myModal<?php echo $row2['id']; ?>" role="dialog">
                    <div class="modal-dialog">
                    </div>
                  </div>
                </div>
              </div>
          <?php } ?>
        </div>
      </div>
      </div>
  </section><!-- End Showcase Section -->
  <!-- ======= Contact Section ======= -->
  <section id="contact" class="contact">
    <div class="container-fluid" style="padding-left: 1%;padding-right:1%">

      <div class="section-title">
        <span>İLETİŞİM</span>
        <h2>İLETİŞİM</h2>
      </div>

      <div class="row" data-aos="fade-up">
        <div class="col-lg-6">
          <div class="info-box  mb-4">
            <i class="bx bx-envelope"></i>
            <h3>Email</h3>
            <p></p>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="info-box  mb-4">
            <i class="bx bx-phone-call"></i>
            <h3>Telefon</h3>
            <p></p>
          </div>
        </div>
      </div>
    </div>
    </div>
  </section><!-- End Contact Section -->

  </main><!-- End #main -->
  <?php include "footer.php"; ?>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
  <script src="assets/js/Slider.js"></script>
  <script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.8.2/js/lightbox.min.js"></script>
  <script type='text/javascript'></script>


</body>

</html>