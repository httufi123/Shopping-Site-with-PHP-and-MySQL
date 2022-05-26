<?php include "header.php";
?>
<?php
include "db.php";
$conn = OpenCon();

error_reporting(0);
$product_id = $_GET['ProductID'];
$grup_id_id = $_GET['grup_id'];

$res = mysqli_query($conn, "SELECT * FROM adword_list WHERE id = $product_id");
while ($row = mysqli_fetch_array($res)) {
  $image = base64_encode($row['image']);
  $name = $row['head_name'];
  $price = $row['price'];
  $category_list_id = $row['category_list_id'];
  $adword_detail = $row['adword_detail'];
  $user_id = $row['user_id'];
  $adword_state = $row['adword_state'];
  $adword_marka = $row['adword_marka'];
  $adword_ebat = $row['adword_ebat'];
  $adword_alan = $row['adword_kullanım_yeri'];
}

//Gives images of products 
$sayac = 0;
$res3 = mysqli_query($conn, "SELECT * FROM adword_image_list WHERE adword_list_id = $product_id");
while ($row3 = mysqli_fetch_array($res3)) {
  $sayac++;
}
$check = 0;

$user = mysqli_query($conn, "SELECT * FROM user_list WHERE id = $user_id");
while ($usr = mysqli_fetch_array($user)) {
  $user_name1 = $usr['first_name'];
  $user_name2 = $usr['nick_name'];
  $user_email = $usr['email'];
  $user_phone = $usr['phone'];
  $user_adres = $usr['adress'];
  $user_city = $usr['city'];
}
?>
<style>
  .carousel {
    padding: 5px;

  }

  div {
    word-wrap: break-word;
  }

  .item .thumb {
    width: 20%;
    cursor: pointer;
    float: left;
    padding-top: 5%;
  }

  .item .thumb img {
    width: 100%;
    margin: 2px;
  }

  .item img {
    width: 100%;
  }

  .nav-pills>li.active>a,
  .nav-pills>li.active>a:focus,
  .nav-pills>li.active>a:hover {
    color: #fff;
    background-color: #c60000 !important;
  }

  .map-container {
    overflow: hidden;
    padding-bottom: 56.25%;
    position: relative;
    height: 0;
  }

  .map-container iframe {
    left: 0;
    top: 0;
    height: 100%;
    width: 100%;
    position: absolute;
  }

  @media(max-width: 767px) {}
</style>

<body>
  <main style="width:100%;padding-left:0px;margin-top:5%">
    <div class="container-fluid" style="width:100%;padding-left:7%">
      <div class="row">

        <div class="col-md-5 col-lg-5 col-sm-12 col-xs-12" style="border:1px solid #e2e2e2;">

          <div id="carousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner" style="display:inline-block;vertical-align:middle;">
              <div class="item active">
                <img src="data:image/jpeg;base64,<?php echo $image; ?>">
              </div>
              <?php $res3 = mysqli_query($conn, "SELECT * FROM adword_image_list WHERE adword_list_id = $product_id");
              while ($row3 = mysqli_fetch_array($res3)) {
              ?>
                <div class="item">
                  <img src="data:image/jpeg;base64,<?php echo base64_encode($row3['image']); ?>">
                </div>
              <?php } ?>
            </div>
          </div>
          <div class="clearfix">
            <div id="thumbcarousel" class="carousel slide" data-interval="false">
              <div class="carousel-inner" style="display:inline-block;vertical-align:middle;">
                <?php if ($sayac <= 4) {
                ?>
                  <div class="item active">
                    <div data-target="#carousel" data-slide-to="0" class="thumb"><img src="data:image/jpeg;base64,<?php echo $image; ?>"></div>
                    <?php $res3 = mysqli_query($conn, "SELECT * FROM adword_image_list WHERE adword_list_id = $product_id");

                    while ($row3 = mysqli_fetch_array($res3)) {
                      $check++;
                    ?>
                      <div data-target="#carousel" data-slide-to="<?php echo $check; ?>" class="thumb"><img src="data:image/jpeg;base64,<?php echo base64_encode($row3['image']); ?>"></div>
                    <?php } ?>
                  </div><!-- /item -->
                <?php } else { ?>
                  <div class="item active">
                    <div data-target="#carousel" data-slide-to="0" class="thumb"><img src="data:image/jpeg;base64,<?php echo $image; ?>"></div>
                    <?php $check = 0;
                    $res3 = mysqli_query($conn, "SELECT * FROM adword_image_list WHERE adword_list_id = $product_id");
                    while ($row3 = mysqli_fetch_array($res3)) {
                      $check++;
                      if ($check == 5) {
                        break;
                      }
                    ?>
                      <div data-target="#carousel" data-slide-to="<?php echo $check; ?>" class="thumb"><img src="data:image/jpeg;base64,<?php echo base64_encode($row3['image']); ?>"></div>
                    <?php } ?>
                  </div>
                  <div class="item">
                    <?php
                    $check = 0;
                    $res3 = mysqli_query($conn, "SELECT * FROM adword_image_list WHERE adword_list_id = $product_id");
                    while ($row3 = mysqli_fetch_array($res3)) {
                      $check++;
                      if ($check > 4) {
                    ?>
                        <div data-target="#carousel" data-slide-to="<?php echo $check; ?>" class="thumb"><img src="data:image/jpeg;base64,<?php echo base64_encode($row3['image']); ?>"></div>
                    <?php }
                    } ?>
                  </div>
                  <a class="left carousel-control" href="#thumbcarousel" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                  </a>
                  <a class="right carousel-control" href="#thumbcarousel" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                  </a>
                <?php } ?>
              </div><!-- /carousel-inner -->
            </div> <!-- /thumbcarousel -->
          </div><!-- /clearfix -->
        </div> <!-- /col-sm-6 -->

        <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12" style="padding-left:10%">

          <body>
            <div class="card" style=" box-shadow: 0 2px 4px 0 rgba(0,0,0,0.2);background-color:#A9A9A9!important;">
              <div class="back">
                <h1 style="text-align:center;"><?php echo $user_name1 . " " . $user_name2; ?></h1>
                <ul>
                  <li style="font-weight: bolder;"> Mail Adresi: <?php echo $user_email; ?></li>
                  <li style="font-weight: bolder;"> Telefon Numarası: <?php echo $user_phone; ?></li>
                  <li style="font-weight: bolder;"> Adres: <?php echo $user_adres; ?></li>
                  <li style="font-weight: bolder;"> Şehir: <?php echo $user_city; ?></li>
                </ul>
              </div>
            </div>
          </body>
          </br>
          </br>
          <div>
            <table style="width:100%">
              <thead>
                <tr>
                  <th>
                  </th>
                  <th>
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr style="border-bottom: 1px solid #9fb6cd;line-height:4rem">
                  <td style="color:#9fb6cd">
                    <b> İlan başlığı: </b>
                  </td>
                  <td>
                    <?php echo $name; ?>
                  </td>
                </tr>
                <tr style="border-bottom: 1px solid #9fb6cd;line-height:4rem">
                  <td style="color:#9fb6cd">
                    <b>Ürün fiyatı: </b>
                  </td>
                  <td>
                    <?php echo $price; ?> ₺
                  </td>
                </tr>
                <tr style="border-bottom: 1px solid #9fb6cd;line-height:4rem">
                  <td style="color:#9fb6cd">
                    <b> Ürün markası: </b>
                  </td>
                  <td>
                    <?php if ($adword_marka == 1) {
                      echo "Achilles";
                    } else if ($adword_marka == 2) {
                      echo "Addo India";
                    } else if ($adword_marka == 3) {
                      echo "Aeolus";
                    } else if ($adword_marka == 4) {
                      echo "Agate";
                    } else if ($adword_marka == 5) {
                      echo "AJS";
                    } else if ($adword_marka == 6) {
                      echo "Alan";
                    } else if ($adword_marka == 7) {
                      echo "Alliance";
                    } else if ($adword_marka == 8) {
                      echo "Altenzo";
                    } else if ($adword_marka == 9) {
                      echo "Altura";
                    } else if ($adword_marka == 10) {
                      echo "Amp Tires";
                    } else if ($adword_marka == 11) {
                      echo "Amtel";
                    } else if ($adword_marka == 12) {
                      echo "Anlas";
                    } else if ($adword_marka == 13) {
                      echo "Annaite";
                    } else if ($adword_marka == 14) {
                      echo "Antares";
                    } else if ($adword_marka == 15) {
                      echo "Anteo";
                    } else if ($adword_marka == 16) {
                      echo "Aoteli";
                    } else if ($adword_marka == 17) {
                      echo "Aplus";
                    } else if ($adword_marka == 18) {
                      echo "Apollo";
                    } else if ($adword_marka == 19) {
                      echo "Aptany";
                    } else if ($adword_marka == 20) {
                      echo "Arestone";
                    } else if ($adword_marka == 21) {
                      echo "Armforce";
                    } else if ($adword_marka == 22) {
                      echo "Armstrong";
                    } else if ($adword_marka == 23) {
                      echo "Arora";
                    } else if ($adword_marka == 24) {
                      echo "Artum";
                    } else if ($adword_marka == 25) {
                      echo "Asya";
                    } else if ($adword_marka == 26) {
                      echo "Atlas";
                    } else if ($adword_marka == 27) {
                      echo "Atrezzo";
                    } else if ($adword_marka == 28) {
                      echo "Austone";
                    } else if ($adword_marka == 29) {
                      echo "Autogrip";
                    } else if ($adword_marka == 30) {
                      echo "Avenger";
                    } else if ($adword_marka == 31) {
                      echo "Barez";
                    } else if ($adword_marka == 32) {
                      echo "Barum";
                    } else if ($adword_marka == 33) {
                      echo "Baysal";
                    } else if ($adword_marka == 34) {
                      echo "Beestone";
                    } else if ($adword_marka == 35) {
                      echo "Belshina";
                    } else if ($adword_marka == 36) {
                      echo "BF Goodrich";
                    } else if ($adword_marka == 37) {
                      echo "Billas";
                    } else if ($adword_marka == 38) {
                      echo "BKT";
                    } else if ($adword_marka == 39) {
                      echo "Blacklion";
                    } else if ($adword_marka == 40) {
                      echo "Blackstone";
                    } else if ($adword_marka == 41) {
                      echo "Blizzard";
                    } else if ($adword_marka == 42) {
                      echo "Boğa Tyres";
                    } else if ($adword_marka == 43) {
                      echo "Bonsun";
                    } else if ($adword_marka == 44) {
                      echo "BossTire";
                    } else if ($adword_marka == 45) {
                      echo "Boto";
                    } else if ($adword_marka == 46) {
                      echo "Bravuris";
                    } else if ($adword_marka == 47) {
                      echo "Bridgestone";
                    } else if ($adword_marka == 48) {
                      echo "Brilliant";
                    } else if ($adword_marka == 49) {
                      echo "Carbon Series";
                    } else if ($adword_marka == 50) {
                      echo "Carlisle";
                    } else if ($adword_marka == 51) {
                      echo "Catch Power";
                    } else if ($adword_marka == 52) {
                      echo "Ceat Iseo";
                    } else if ($adword_marka == 53) {
                      echo "Champiro";
                    } else if ($adword_marka == 54) {
                      echo "Cheng Shin";
                    } else if ($adword_marka == 55) {
                      echo "Chopper";
                    } else if ($adword_marka == 56) {
                      echo "Comfort";
                    } else if ($adword_marka == 57) {
                      echo "Compasal";
                    } else if ($adword_marka == 58) {
                      echo "Constancy";
                    } else if ($adword_marka == 59) {
                      echo "Continental";
                    } else if ($adword_marka == 60) {
                      echo "Cooper";
                    } else if ($adword_marka == 61) {
                      echo "Cordiant";
                    } else if ($adword_marka == 62) {
                      echo "Courier";
                    } else if ($adword_marka == 63) {
                      echo "Cratos";
                    } else if ($adword_marka == 64) {
                      echo "Cultor";
                    } else if ($adword_marka == 65) {
                      echo "Dayton";
                    } else if ($adword_marka == 66) {
                      echo "Debica";
                    } else if ($adword_marka == 67) {
                      echo "Deestone";
                    } else if ($adword_marka == 68) {
                      echo "Delinte";
                    } else if ($adword_marka == 69) {
                      echo "Delitire";
                    } else if ($adword_marka == 70) {
                      echo "Deruibo";
                    } else if ($adword_marka == 71) {
                      echo "Diplomat";
                    } else if ($adword_marka == 72) {
                      echo "Dmack";
                    } else if ($adword_marka == 73) {
                      echo "Dneproshina";
                    } else if ($adword_marka == 74) {
                      echo "Doublestar";
                    } else if ($adword_marka == 75) {
                      echo "Dunlop";
                    } else if ($adword_marka == 76) {
                      echo "Blizzard";
                    } else if ($adword_marka == 77) {
                      echo "Duraturn";
                    } else if ($adword_marka == 78) {
                      echo "Duravis";
                    } else if ($adword_marka == 79) {
                      echo "Duro";
                    } else if ($adword_marka == 80) {
                      echo "Effiplus";
                    } else if ($adword_marka == 81) {
                      echo "ERC";
                    } else if ($adword_marka == 82) {
                      echo "Esa+Tecar";
                    } else if ($adword_marka == 83) {
                      echo "Eurogrip";
                    } else if ($adword_marka == 84) {
                      echo "Eurotyre";
                    } else if ($adword_marka == 85) {
                      echo "Evergreen";
                    } else if ($adword_marka == 86) {
                      echo "Evermax";
                    } else if ($adword_marka == 87) {
                      echo "Falken";
                    } else if ($adword_marka == 88) {
                      echo "Faralong";
                    } else if ($adword_marka == 89) {
                      echo "Farroad";
                    } else if ($adword_marka == 90) {
                      echo "Fate";
                    } else if ($adword_marka == 91) {
                      echo "Federal";
                    } else if ($adword_marka == 92) {
                      echo "Fedima";
                    } else if ($adword_marka == 93) {
                      echo "Feu Vert";
                    } else if ($adword_marka == 94) {
                      echo "Firenza";
                    } else if ($adword_marka == 95) {
                      echo "FireStone";
                    } else if ($adword_marka == 96) {
                      echo "Fisk";
                    } else if ($adword_marka == 97) {
                      echo "Formula Energy";
                    } else if ($adword_marka == 98) {
                      echo "Fronway";
                    } else if ($adword_marka == 99) {
                      echo "Fulda";
                    } else if ($adword_marka == 100) {
                      echo "Fullrun";
                    } else if ($adword_marka == 101) {
                      echo "General Tire";
                    } else if ($adword_marka == 102) {
                      echo "Geroni";
                    } else if ($adword_marka == 103) {
                      echo "Gislaved";
                    } else if ($adword_marka == 104) {
                      echo "Globe Star";
                    } else if ($adword_marka == 105) {
                      echo "Goalstar";
                    } else if ($adword_marka == 106) {
                      echo "Golden Bridge";
                    } else if ($adword_marka == 107) {
                      echo "Goldline";
                    } else if ($adword_marka == 108) {
                      echo "Goodrich";
                    } else if ($adword_marka == 109) {
                      echo "Goodride";
                    } else if ($adword_marka == 110) {
                      echo "Goodyear";
                    } else if ($adword_marka == 111) {
                      echo "Greckster";
                    } else if ($adword_marka == 112) {
                      echo "Greentrac";
                    } else if ($adword_marka == 113) {
                      echo "Gremax";
                    } else if ($adword_marka == 114) {
                      echo "Grenlander";
                    } else if ($adword_marka == 115) {
                      echo "Gripmax";
                    } else if ($adword_marka == 116) {
                      echo "GT Radial";
                    } else if ($adword_marka == 117) {
                      echo "Haida";
                    } else if ($adword_marka == 118) {
                      echo "Hankook";
                    } else if ($adword_marka == 119) {
                      echo "Heidenau";
                    } else if ($adword_marka == 120) {
                      echo "Hercules";
                    } else if ($adword_marka == 121) {
                      echo "Hero";
                    } else if ($adword_marka == 122) {
                      echo "Hifly";
                    } else if ($adword_marka == 123) {
                      echo "Honda";
                    } else if ($adword_marka == 124) {
                      echo "Hoosier";
                    } else if ($adword_marka == 125) {
                      echo "Horng Fortune";
                    } else if ($adword_marka == 126) {
                      echo "Hunter";
                    } else if ($adword_marka == 127) {
                      echo "Imperial";
                    } else if ($adword_marka == 128) {
                      echo "Infinity";
                    } else if ($adword_marka == 129) {
                      echo "Insa Turbo";
                    } else if ($adword_marka == 130) {
                      echo "Interco Tire";
                    } else if ($adword_marka == 131) {
                      echo "Intertrac";
                    } else if ($adword_marka == 132) {
                      echo "IRC";
                    } else if ($adword_marka == 133) {
                      echo "Italmatic";
                    } else if ($adword_marka == 134) {
                      echo "ITP";
                    } else if ($adword_marka == 135) {
                      echo "Jinyu";
                    } else if ($adword_marka == 136) {
                      echo "JK Tyre";
                    } else if ($adword_marka == 137) {
                      echo "Joyroad";
                    } else if ($adword_marka == 138) {
                      echo "Kama";
                    } else if ($adword_marka == 139) {
                      echo "Kapsen";
                    } else if ($adword_marka == 140) {
                      echo "Kelly";
                    } else if ($adword_marka == 141) {
                      echo "Kenda";
                    } else if ($adword_marka == 142) {
                      echo "Kenex";
                    } else if ($adword_marka == 143) {
                      echo "Keter";
                    } else if ($adword_marka == 144) {
                      echo "Kinforest";
                    } else if ($adword_marka == 145) {
                      echo "Kingstar";
                    } else if ($adword_marka == 146) {
                      echo "Kleber";
                    } else if ($adword_marka == 147) {
                      echo "Koçlas";
                    } else if ($adword_marka == 148) {
                      echo "Kooler";
                    } else if ($adword_marka == 149) {
                      echo "Kormoran";
                    } else if ($adword_marka == 150) {
                      echo "KRM";
                    } else if ($adword_marka == 151) {
                      echo "Kumho";
                    } else if ($adword_marka == 152) {
                      echo "Landsail";
                    } else if ($adword_marka == 153) {
                      echo "Lanvigator";
                    } else if ($adword_marka == 154) {
                      echo "Lassa";
                    } else if ($adword_marka == 155) {
                      echo "Laufenn";
                    } else if ($adword_marka == 156) {
                      echo "Linglong";
                    } else if ($adword_marka == 157) {
                      echo "Luhe";
                    } else if ($adword_marka == 158) {
                      echo "Mabor";
                    } else if ($adword_marka == 159) {
                      echo "Marangoni";
                    } else if ($adword_marka == 160) {
                      echo "Marshall";
                    } else if ($adword_marka == 161) {
                      echo "Mastercraft";
                    } else if ($adword_marka == 162) {
                      echo "Matador";
                    } else if ($adword_marka == 163) {
                      echo "Maxam";
                    } else if ($adword_marka == 164) {
                      echo "Maxima";
                    } else if ($adword_marka == 165) {
                      echo "Maxtrek";
                    } else if ($adword_marka == 166) {
                      echo "Maxxis";
                    } else if ($adword_marka == 167) {
                      echo "Mazzini";
                    } else if ($adword_marka == 168) {
                      echo "Membat";
                    } else if ($adword_marka == 169) {
                      echo "Mentor";
                    } else if ($adword_marka == 170) {
                      echo "Metzeler";
                    } else if ($adword_marka == 171) {
                      echo "Michelin";
                    } else if ($adword_marka == 172) {
                      echo "Mickey Thompson";
                    } else if ($adword_marka == 173) {
                      echo "Milestone";
                    } else if ($adword_marka == 174) {
                      echo "Millennium";
                    } else if ($adword_marka == 175) {
                      echo "Minerva";
                    } else if ($adword_marka == 176) {
                      echo "Minnell";
                    } else if ($adword_marka == 177) {
                      echo "Mitas";
                    } else if ($adword_marka == 178) {
                      echo "Mohawk";
                    } else if ($adword_marka == 179) {
                      echo "Momo";
                    } else if ($adword_marka == 180) {
                      echo "Motrio";
                    } else if ($adword_marka == 181) {
                      echo "MRF";
                    } else if ($adword_marka == 182) {
                      echo "Mudstar";
                    } else if ($adword_marka == 183) {
                      echo "Nankang";
                    } else if ($adword_marka == 184) {
                      echo "Neuton";
                    } else if ($adword_marka == 185) {
                      echo "Nexen";
                    } else if ($adword_marka == 186) {
                      echo "Nitto";
                    } else if ($adword_marka == 187) {
                      echo "Nokian";
                    } else if ($adword_marka == 188) {
                      echo "Nordexx";
                    } else if ($adword_marka == 189) {
                      echo "Numa";
                    } else if ($adword_marka == 190) {
                      echo "Orium";
                    } else if ($adword_marka == 191) {
                      echo "Ornet";
                    } else if ($adword_marka == 192) {
                      echo "Otani";
                    } else if ($adword_marka == 193) {
                      echo "Ovation";
                    } else if ($adword_marka == 194) {
                      echo "Özka";
                    } else if ($adword_marka == 195) {
                      echo "Pace";
                    } else if ($adword_marka == 196) {
                      echo "Petlas";
                    } else if ($adword_marka == 197) {
                      echo "Pirelli";
                    } else if ($adword_marka == 198) {
                      echo "Planet";
                    } else if ($adword_marka == 199) {
                      echo "Platin";
                    } else if ($adword_marka == 200) {
                      echo "Pneumant";
                    } else if ($adword_marka == 201) {
                      echo "Point S";
                    } else if ($adword_marka == 202) {
                      echo "Pola";
                    } else if ($adword_marka == 203) {
                      echo "Powerstone";
                    } else if ($adword_marka == 204) {
                      echo "PowerTrac";
                    } else if ($adword_marka == 205) {
                      echo "Premiorri";
                    } else if ($adword_marka == 206) {
                      echo "Presa";
                    } else if ($adword_marka == 207) {
                      echo "Primewell";
                    } else if ($adword_marka == 208) {
                      echo "Radar";
                    } else if ($adword_marka == 209) {
                      echo "Radial";
                    } else if ($adword_marka == 210) {
                      echo "Raiden Tires";
                    } else if ($adword_marka == 211) {
                      echo "Regal";
                    } else if ($adword_marka == 212) {
                      echo "Riken";
                    } else if ($adword_marka == 213) {
                      echo "Roadcruza";
                    } else if ($adword_marka == 214) {
                      echo "Roadstone";
                    } else if ($adword_marka == 215) {
                      echo "Rosava";
                    } else if ($adword_marka == 216) {
                      echo "Rotalla";
                    } else if ($adword_marka == 217) {
                      echo "Rotex";
                    } else if ($adword_marka == 218) {
                      echo "Royal Black";
                    } else if ($adword_marka == 219) {
                      echo "Rubber King";
                    } else if ($adword_marka == 220) {
                      echo "Runway";
                    } else if ($adword_marka == 221) {
                      echo "Saferich";
                    } else if ($adword_marka == 222) {
                      echo "Sailun";
                    } else if ($adword_marka == 223) {
                      echo "Sakura";
                    } else if ($adword_marka == 224) {
                      echo "Sava";
                    } else if ($adword_marka == 225) {
                      echo "Schwalbe";
                    } else if ($adword_marka == 226) {
                      echo "Scudo";
                    } else if ($adword_marka == 227) {
                      echo "Seatta";
                    } else if ($adword_marka == 228) {
                      echo "Sebring";
                    } else if ($adword_marka == 229) {
                      echo "Semperit";
                    } else if ($adword_marka == 230) {
                      echo "Silver Stone";
                    } else if ($adword_marka == 231) {
                      echo "Simex";
                    } else if ($adword_marka == 232) {
                      echo "Solideal";
                    } else if ($adword_marka == 233) {
                      echo "Solido";
                    } else if ($adword_marka == 234) {
                      echo "Solimax";
                    } else if ($adword_marka == 235) {
                      echo "Solitrac";
                    } else if ($adword_marka == 236) {
                      echo "Solus";
                    } else if ($adword_marka == 237) {
                      echo "Sonar";
                    } else if ($adword_marka == 238) {
                      echo "Sonny";
                    } else if ($adword_marka == 239) {
                      echo "Speedways";
                    } else if ($adword_marka == 240) {
                      echo "Spider";
                    } else if ($adword_marka == 241) {
                      echo "Sportiva";
                    } else if ($adword_marka == 242) {
                      echo "Sportrak";
                    } else if ($adword_marka == 243) {
                      echo "Starfire";
                    } else if ($adword_marka == 244) {
                      echo "Starmaxx";
                    } else if ($adword_marka == 245) {
                      echo "Strial";
                    } else if ($adword_marka == 246) {
                      echo "Stunner";
                    } else if ($adword_marka == 247) {
                      echo "Sumitomo";
                    } else if ($adword_marka == 248) {
                      echo "Sumo";
                    } else if ($adword_marka == 249) {
                      echo "Sunbear";
                    } else if ($adword_marka == 250) {
                      echo "SunF";
                    } else if ($adword_marka == 251) {
                      echo "Sunitrac";
                    } else if ($adword_marka == 252) {
                      echo "Sunny";
                    } else if ($adword_marka == 253) {
                      echo "Suntek";
                    } else if ($adword_marka == 254) {
                      echo "Sunwide";
                    } else if ($adword_marka == 255) {
                      echo "Superking";
                    } else if ($adword_marka == 256) {
                      echo "Super Swamper";
                    } else if ($adword_marka == 257) {
                      echo "Swallow";
                    } else if ($adword_marka == 258) {
                      echo "Syron";
                    } else if ($adword_marka == 259) {
                      echo "Talon";
                    } else if ($adword_marka == 260) {
                      echo "Tatko";
                    } else if ($adword_marka == 261) {
                      echo "Taurus";
                    } else if ($adword_marka == 262) {
                      echo "TFT";
                    } else if ($adword_marka == 263) {
                      echo "Three A";
                    } else if ($adword_marka == 264) {
                      echo "Thunderer";
                    } else if ($adword_marka == 265) {
                      echo "Tigar";
                    } else if ($adword_marka == 266) {
                      echo "Tiron";
                    } else if ($adword_marka == 267) {
                      echo "Tokai";
                    } else if ($adword_marka == 268) {
                      echo "Toprunner";
                    } else if ($adword_marka == 269) {
                      echo "Torque";
                    } else if ($adword_marka == 270) {
                      echo "Touring";
                    } else if ($adword_marka == 271) {
                      echo "Tovic";
                    } else if ($adword_marka == 272) {
                      echo "Toyo";
                    } else if ($adword_marka == 273) {
                      echo "Tracmax";
                    } else if ($adword_marka == 274) {
                      echo "Transking";
                    } else if ($adword_marka == 275) {
                      echo "Transporter";
                    } else if ($adword_marka == 276) {
                      echo "Trayal";
                    } else if ($adword_marka == 277) {
                      echo "Tri-Ace";
                    } else if ($adword_marka == 278) {
                      echo "Triangle";
                    } else if ($adword_marka == 279) {
                      echo "Tristar";
                    } else if ($adword_marka == 280) {
                      echo "Tyrex";
                    } else if ($adword_marka == 281) {
                      echo "Unilli";
                    } else if ($adword_marka == 282) {
                      echo "Uniroyal";
                    } else if ($adword_marka == 283) {
                      echo "Vee Rubber";
                    } else if ($adword_marka == 284) {
                      echo "Victorun";
                    } else if ($adword_marka == 285) {
                      echo "Viking";
                    } else if ($adword_marka == 286) {
                      echo "Vitour";
                    } else if ($adword_marka == 287) {
                      echo "Viva";
                    } else if ($adword_marka == 288) {
                      echo "V-Netik";
                    } else if ($adword_marka == 289) {
                      echo "Vredstein";
                    } else if ($adword_marka == 290) {
                      echo "Wanli";
                    } else if ($adword_marka == 291) {
                      echo "Waterfall";
                    } else if ($adword_marka == 292) {
                      echo "Watts";
                    } else if ($adword_marka == 293) {
                      echo "West Lake";
                    } else if ($adword_marka == 294) {
                      echo "Windforce";
                    } else if ($adword_marka == 295) {
                      echo "Winguard";
                    } else if ($adword_marka == 296) {
                      echo "Winrun";
                    } else if ($adword_marka == 297) {
                      echo "Woosung";
                    } else if ($adword_marka == 298) {
                      echo "Wosen";
                    } else if ($adword_marka == 299) {
                      echo "Yamaha";
                    } else if ($adword_marka == 300) {
                      echo "Yatone";
                    } else if ($adword_marka == 301) {
                      echo "Yokohama";
                    } else if ($adword_marka == 302) {
                      echo "Yuanxing";
                    } else if ($adword_marka == 303) {
                      echo "Zeetex";
                    } else if ($adword_marka == 304) {
                      echo "Zestino";
                    } else if ($adword_marka == 305) {
                      echo "Zeta";
                    } else if ($adword_marka == 306) {
                      echo "Zetum";
                    } else if ($adword_marka == 307) {
                      echo "Bosch";
                    } else if ($adword_marka == 308) {
                      echo "Makita";
                    } else if ($adword_marka == 309) {
                      echo "Ceta Form";
                    } else if ($adword_marka == 310) {
                      echo "S-Link";
                    } else if ($adword_marka == 311) {
                      echo "Einhell";
                    } else if ($adword_marka == 312) {
                      echo "Honda";
                    } else if ($adword_marka == 313) {
                      echo "AEG";
                    } else if ($adword_marka == 314) {
                      echo "Yamaha";
                    } else if ($adword_marka == 315) {
                      echo "Ttec";
                    } else if ($adword_marka == 316) {
                      echo "Powermaster";
                    } else if ($adword_marka == 317) {
                      echo "Dewalt";
                    } else if ($adword_marka == 318) {
                      echo "BMW";
                    } else if ($adword_marka == 319) {
                      echo "Klpro";
                    } else if ($adword_marka == 320) {
                      echo "Dremel";
                    } else if ($adword_marka == 321) {
                      echo "3M";
                    } else if ($adword_marka == 322) {
                      echo "Duracell";
                    } else if ($adword_marka == 323) {
                      echo "RTRMAX";
                    } else if ($adword_marka == 324) {
                      echo "Varta";
                    } else if ($adword_marka == 325) {
                      echo "Safir";
                    } else if ($adword_marka == 326) {
                      echo "Max Extra";
                    } else if ($adword_marka == 327) {
                      echo "Hitachi";
                    } else if ($adword_marka == 328) {
                      echo "Ryobi";
                    } else if ($adword_marka == 329) {
                      echo "Yuasa";
                    } else if ($adword_marka == 330) {
                      echo "Tunçmatik";
                    } else if ($adword_marka == 331) {
                      echo "Mutlu";
                    } else if ($adword_marka == 332) {
                      echo "Orbus";
                    } else if ($adword_marka == 333) {
                      echo "Energy";
                    } else if ($adword_marka == 334) {
                      echo "NOVA";
                    } else if ($adword_marka == 335) {
                      echo "Makelsan";
                    } else if ($adword_marka == 336) {
                      echo "Ataba";
                    } else if ($adword_marka == 337) {
                      echo "Çelik";
                    } else if ($adword_marka == 338) {
                      echo "Mervesan";
                    } else if ($adword_marka == 339) {
                      echo "Inform";
                    } else if ($adword_marka == 340) {
                      echo "Vlm Akü";
                    } else if ($adword_marka == 341) {
                      echo "Atex";
                    } else if ($adword_marka == 342) {
                      echo "Erbauer";
                    } else if ($adword_marka == 343) {
                      echo "Ortec";
                    } else if ($adword_marka == 344) {
                      echo "İnci";
                    } else if ($adword_marka == 345) {
                      echo "Presiden";
                    } else if ($adword_marka == 346) {
                      echo "Orion";
                    } else if ($adword_marka == 347) {
                      echo "Volt";
                    } else if ($adword_marka == 348) {
                      echo "Lexron";
                    } else if ($adword_marka == 349) {
                      echo "Abg";
                    } else if ($adword_marka == 350) {
                      echo "Hugel";
                    } else if ($adword_marka == 351) {
                      echo "Yiğit";
                    } else {
                      echo "Diğer";
                    }
                    ?>
                  </td>
                </tr>
                <?php if ($grup_id_id != 2) {  ?>
                  <tr style="border-bottom: 1px solid #9fb6cd;line-height:4rem">
                    <td style="color:#9fb6cd">
                      <b> Ürün ebatı: </b>
                    </td>
                    <td>
                      <?php
                      if ($adword_ebat == 1) {
                        echo "12 inç";
                      } else if ($adword_ebat == 2) {
                        echo "13 inç";
                      } else if ($adword_ebat == 3) {
                        echo "14 inç";
                      } else if ($adword_ebat == 4) {
                        echo "15 inç";
                      } else if ($adword_ebat == 5) {
                        echo "16 inç";
                      } else if ($adword_ebat == 6) {
                        echo "17 inç";
                      } else if ($adword_ebat == 7) {
                        echo "18 inç";
                      } else if ($adword_ebat == 8) {
                        echo "19 inç";
                      } else if ($adword_ebat == 9) {
                        echo "20+ inç";
                      } else if ($adword_ebat == 10) {
                        echo "145-195 mm";
                      } else if ($adword_ebat == 11) {
                        echo "195-245 mm";
                      } else if ($adword_ebat == 12) {
                        echo "245-295 mm";
                      } else if ($adword_ebat == 13) {
                        echo "295-345 mm";
                      } else if ($adword_ebat == 14) {
                        echo "395++ mm";
                      } else {
                        echo "Diğer";
                      }
                      ?>
                    </td>
                  </tr>
                <?php } ?>
                <tr style="border-bottom: 1px solid #9fb6cd;line-height:4rem">
                  <td style="color:#9fb6cd">
                    
                </tr>
              </tbody>
            </table>
          </div>
        </div> <!-- /col-sm-6 -->
      </div> <!-- /row -->
      <div class="row" style="padding-top: 10%;">
        <div class="col-11 col-xs-12">
          <ul class="nav nav-pills">
            <li class="active"><a data-toggle="pill" href="#home" id="alı">Açıklama</a></li>
            <li><a data-toggle="pill" href="#menu1" id="alı">Konum</a></li>
          </ul>
          <div class="tab-content" style="border-top:2px solid #c60000;min-height:20rem;max-height:fit-content">
            <div id="home" class="tab-pane fade in active">
              <div style="overflow-y:scroll;width:100%">
                <h5><?php echo $adword_detail;
                    if ($adword_detail == null) {
                      echo "Ürün ile ilgili açıklama bulunmamaktadır.";
                    }
                    ?>
                </h5>
              </div>
            </div>
            <div id="menu1" class="tab-pane fade" style="overflow-y:scroll;height:50rem;width:100%">
              <div id="map-container-google-1" class="z-depth-1-half map-container" style="height: 500px">
                <iframe frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.it/maps?q= <?php echo $user_adres . "/" . $user_city . "/" . $ilce; ?>y&output=embed" allowfullscreen></iframe>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div> <!-- /container -->
  </main>
  <br> <br> <br> <br> <br>
  <?php include "footer.php";  ?>
  <link rel="stylesheet" href="assets/css/product.css">
  <script src="assets/js/main.js"></script>
  <script src="assets/js/Slider.js"></script>
  <script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>

</html>