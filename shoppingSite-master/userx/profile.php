<?php
include "db.php";
include "header.php";
$conn = OpenCon();

error_reporting(0);
session_start();
$user_id = $_SESSION["user_id"];

$usr = mysqli_query($conn, "SELECT * FROM user_list WHERE id = $user_id");
while ($row = mysqli_fetch_array($usr)) {
  $f_name = $row['first_name'];
  $n_name = $row['nick_name'];
  $username = $row['username'];
  $password = $row['password'];
  $email = $row['email'];
  $tel = $row['phone'];
  $adres = $row['adress'];
  $city = $row['city'];
}

if (isset($_POST['update']) && $_SERVER['REQUEST_METHOD'] == 'POST') {

  $val1 = $_POST['first_name'];
  $val2 = $_POST['last_name'];
  $val3 = $_POST['user_name'];
  $val4 = $_POST['user_password'];
  $val5 = $_POST['confirm_password'];
  $val6 = $_POST['email'];
  $val7 = $_POST['contact_no'];
  $val8 = $_POST['adres'];
  $val9 = $_POST['city'];

  if ($val1 != null && $val2 != null && $val3 != null && $val4 != null && $val5 != null && $val6 != null && $val7 != null && $val8 != null && $val9 != null) {

    if ($val4 == $val5) {

      $sql_city = "UPDATE adword_list SET city = " . "'$val9'" . " WHERE user_id = $user_id";
      mysqli_query($conn, $sql_city);


      $sql = "UPDATE user_list SET first_name = " . "'$val1'" . " , nick_name = " . "'$val2'" . " , username = " . "'$val3'" . " , password=" . "'$val4'" . " , email = " . "'$val6'" . "
        , phone  = $val7 , adress= " . "'$val8'" . " , city=" . "'$val9'" . " , country=" . "'$val10'" . " WHERE id=$user_id";
      $check = mysqli_query($conn, $sql);
      if ($check) {
        echo '<script language="javascript">';
        echo 'alert("Profil güncellenmiştir")';  //not showing an alert box.
        echo '</script>';
      } else {
        echo '<script language="javascript">';
        echo 'alert("İlan güncellenme başarısız!")';  //not showing an alert box.
        echo '</script>';
      }
    } else {
      print_r("Paralolar birbiriyle eşleşmiyor!!");
    }
  } else {
    print_r("Lütfen Kutuları Boş Bırakmayınız");
  }
  header("Refresh:0");
}
?>
<!DOCTYPE html>
<!-- Created by CodingLab |www.youtube.com/c/CodingLabYT-->
<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8">
  <title> </title>
  <link rel="stylesheet" href="style.css">
  <!-- Boxicons CDN Link -->
  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
  <link href="https://fonts.googleapis.com/css?family=Playfair+Display:700|Raleway:500.700" rel="stylesheet" />
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="card.css">
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

    a,
    a:hover,
    a:focus {
      color: inherit;
      text-decoration: none;
      transition: all 0.3s;
    }



    .line {
      width: 100%;
      height: 1px;
      border-bottom: 1px dashed #ddd;
      margin: 40px 0;
    }

    /* ---------------------------------------------------
    SIDEBAR STYLE
----------------------------------------------------- */

    .wrapper {
      display: flex;
      width: 100%;
      align-items: stretch;
    }


    .dropdown-toggle::after {
      display: block;
      position: absolute;
      top: 50%;
      right: 20px;
      transform: translateY(-50%);
    }

    ul ul a {
      font-size: 0.9em !important;
      padding-left: 30px !important;
      background: #6d7fcc;
    }

    ul.CTAs {
      padding: 20px;
    }

    ul.CTAs a {
      text-align: center;
      font-size: 0.9em !important;
      display: block;
      border-radius: 5px;
      margin-bottom: 5px;
    }

    a.download {
      background: #fff;
      color: #7386D5;
    }

    a.article,
    a.article:hover {
      background: #6d7fcc !important;
      color: #fff !important;
    }

    /* ---------------------------------------------------
    CONTENT STYLE
----------------------------------------------------- */
    #content {
      width: 100%;
      padding: 20px;
      min-height: 100vh;
      transition: all 0.3s;
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
    <form class=" form-horizontal" style="background-color: transparent;border:0px solid;padding-left:4%" action=" " method="post" enctype="multipart/form-data" id="contact_form">

      <div style="text-align: center">
        <h2>Profili Güncelle</h2><br>
        <hr style="width: 80%;margin-left:10%;border: 1px solid white">
      </div>

      <!-- Text input-->

      <div class="form-group">
        <label class="col-md-4 control-label" style="color:#6d7fcc">Adınız:</label>
        <div class="col-md-5 inputGroupContainer">
          <div class="input-group">
            <input name="first_name" placeholder="First Name" class="form-control" type="text" value="<?php echo $f_name;  ?>">
            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
          </div>
        </div>
      </div>

      <!-- Text input-->

      <div class="form-group">
        <label class="col-md-4 control-label" style="color:#6d7fcc">Soyadınız:</label>
        <div class="col-md-5 inputGroupContainer">
          <div class="input-group">
            <input name="last_name" placeholder="Last Name" class="form-control" type="text" value="<?php echo $n_name;  ?>">
            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
          </div>
        </div>
      </div>


      <!-- Text input-->

      <div class="form-group">
        <label class="col-md-4 control-label" style="color:#6d7fcc">Kullanıcı Adınız:</label>
        <div class="col-md-5 inputGroupContainer">
          <div class="input-group">
            <input name="user_name" placeholder="Username" class="form-control" type="text" value="<?php echo $username;  ?>">
            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
          </div>
        </div>
      </div>

      <!-- Text input-->

      <div class="form-group">
        <label class="col-md-4 control-label" style="color:#6d7fcc">Şifreniz:</label>
        <div class="col-md-5 inputGroupContainer">
          <div class="input-group">
            <input name="user_password" placeholder="Password" class="form-control" type="password" value="<?php echo $password;  ?>">
            <span class="input-group-addon"><i class="fas fa-key"></i></span>
          </div>
        </div>
      </div>

      <!-- Text input-->

      <div class="form-group">
        <label class="col-md-4 control-label" style="color:#6d7fcc">Şifre Tekrarı:</label>
        <div class="col-md-5 inputGroupContainer">
          <div class="input-group">
            <input name="confirm_password" placeholder="Confirm Password" class="form-control" type="password" value="<?php echo $password;  ?>">
            <span class="input-group-addon"><i class="fas fa-key"></i></span>
          </div>
        </div>
      </div>

      <!-- Text input-->
      <div class="form-group">
        <label class="col-md-4 control-label" style="color:#6d7fcc">E-Mail:</label>
        <div class="col-md-5 inputGroupContainer">
          <div class="input-group">
            <input name="email" placeholder="E-Mail Address" class="form-control" type="text" value="<?php echo $email;  ?>">
            <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
          </div>
        </div>
      </div>


      <!-- Text input-->

      <div class="form-group">
        <label class="col-md-4 control-label" style="color:#6d7fcc">Telefon Numaranız:</label>
        <div class="col-md-5 inputGroupContainer">
          <div class="input-group">
            <input name="contact_no" class="form-control" type="text" value="<?php echo $tel;  ?>">
            <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
          </div>
        </div>
      </div>

      <!-- Select Basic -->

      <div class="form-group">
        <label class="col-md-4 control-label" style="color:#6d7fcc">Adresiniz:</label>
        <div class="col-md-5 inputGroupContainer">
          <div class="input-group">
            <input name="adres" class="form-control" type="text" value="<?php echo $adres;  ?>">
            <span class="input-group-addon"><i class="fa fa-home"></i></span>
          </div>
        </div>
      </div>


      <div class="form-group">
        <label class="col-md-4 control-label" style="color:#6d7fcc">Yaşadığınız Şehir:</label>
        <div class="col-md-5 inputGroupContainer">
          <div class="input-group">
            <select class="form-control" name="city">
              <option value="none" selected="" disabled="">İl</option>
              <option value="Adana" <?php if ($city == 'Adana') {
                                      echo "selected";
                                    } ?>>Adana</option>
              <option value="Adıyaman" <?php if ($city == 'Adıyaman') {
                                          echo "selected";
                                        } ?>>Adıyaman</option>
              <option value="Afyonkarahisar" <?php if ($city == 'Afyonkarahisar') {
                                                echo "selected";
                                              } ?>>Afyonkarahisar</option>
              <option value="Ağrı" <?php if ($city == 'Ağrı') {
                                      echo "selected";
                                    } ?>>Ağrı</option>
              <option value="Amasya" <?php if ($city == 'Amasya') {
                                        echo "selected";
                                      } ?>>Amasya</option>
              <option value="Ankara" <?php if ($city == 'Ankara') {
                                        echo "selected";
                                      } ?>>Ankara</option>
              <option value="Antalya" <?php if ($city == 'Antalya') {
                                        echo "selected";
                                      } ?>>Antalya</option>
              <option value="Artvin" <?php if ($city == 'Artvin') {
                                        echo "selected";
                                      } ?>>Artvin</option>
              <option value="Aydın" <?php if ($city == 'Aydın') {
                                      echo "selected";
                                    } ?>>Aydın</option>
              <option value="Balıkesir" <?php if ($city == 'Balıkesir') {
                                          echo "selected";
                                        } ?>>Balıkesir</option>
              <option value="Bilecik" <?php if ($city == 'Bilecik') {
                                        echo "selected";
                                      } ?>>Bilecik</option>
              <option value="Bingöl" <?php if ($city == 'Bingöl') {
                                        echo "selected";
                                      } ?>>Bingöl</option>
              <option value="Bitlis" <?php if ($city == 'Bitlis') {
                                        echo "selected";
                                      } ?>>Bitlis</option>
              <option value="Bolu" <?php if ($city == 'Bolu') {
                                      echo "selected";
                                    } ?>>Bolu</option>
              <option value="Burdur" <?php if ($city == 'Burdur') {
                                        echo "selected";
                                      } ?>>Burdur</option>
              <option value="Bursa" <?php if ($city == 'Bursa') {
                                      echo "selected";
                                    } ?>>Bursa</option>
              <option value="Çanakkale" <?php if ($city == 'Çanakkale') {
                                          echo "selected";
                                        } ?>>Çanakkale</option>
              <option value="Çankırı" <?php if ($city == 'Çankırı') {
                                        echo "selected";
                                      } ?>>Çankırı</option>
              <option value="Çorum" <?php if ($city == 'Çorum') {
                                      echo "selected";
                                    } ?>>Çorum</option>
              <option value="Denizli" <?php if ($city == 'Denizli') {
                                        echo "selected";
                                      } ?>>Denizli</option>
              <option value="Diyarbakır" <?php if ($city == 'Diyarbakır') {
                                            echo "selected";
                                          } ?>>Diyarbakır</option>
              <option value="Edirne" <?php if ($city == 'Edirne') {
                                        echo "selected";
                                      } ?>>Edirne</option>
              <option value="Elazığ" <?php if ($city == 'Elazığ') {
                                        echo "selected";
                                      } ?>>Elazığ</option>
              <option value="Erzincan" <?php if ($city == 'Erzincan') {
                                          echo "selected";
                                        } ?>>Erzincan</option>
              <option value="Erzurum" <?php if ($city == 'Erzurum') {
                                        echo "selected";
                                      } ?>>Erzurum</option>
              <option value="Eskişehir" <?php if ($city == 'Eskişehir') {
                                          echo "selected";
                                        } ?>>Eskişehir</option>
              <option value="Gaziantep" <?php if ($city == 'Gaziantep') {
                                          echo "selected";
                                        } ?>>Gaziantep</option>
              <option value="Giresun" <?php if ($city == 'Giresun') {
                                        echo "selected";
                                      } ?>>Giresun</option>
              <option value="Gümüşhane" <?php if ($city == 'Gümüşhane') {
                                          echo "selected";
                                        } ?>>Gümüşhane</option>
              <option value="Hakkari" <?php if ($city == 'Hakkari') {
                                        echo "selected";
                                      } ?>>Hakkâri</option>
              <option value="Hatay" <?php if ($city == 'Hatay') {
                                      echo "selected";
                                    } ?>>Hatay</option>
              <option value="Isparta" <?php if ($city == 'Isparta') {
                                        echo "selected";
                                      } ?>>Isparta</option>
              <option value="Mersin" <?php if ($city == 'Mersin') {
                                        echo "selected";
                                      } ?>>Mersin</option>
              <option value="İstanbul" <?php if ($city == 'İstanbul') {
                                          echo "selected";
                                        } ?>>İstanbul</option>
              <option value="İzmir" <?php if ($city == 'İzmir') {
                                      echo "selected";
                                    } ?>>İzmir</option>
              <option value="Kars" <?php if ($city == 'Kars') {
                                      echo "selected";
                                    } ?>>Kars</option>
              <option value="Kastamonu" <?php if ($city == 'Kastamonu') {
                                          echo "selected";
                                        } ?>>Kastamonu</option>
              <option value="Kayseri" <?php if ($city == 'Kayseri') {
                                        echo "selected";
                                      } ?>>Kayseri</option>
              <option value="Kırklareli" <?php if ($city == 'Kırklareli') {
                                            echo "selected";
                                          } ?>>Kırklareli</option>
              <option value="Kırşehir" <?php if ($city == 'Kırşehir') {
                                          echo "selected";
                                        } ?>>Kırşehir</option>
              <option value="Kocaeli" <?php if ($city == 'Kocaeli') {
                                        echo "selected";
                                      } ?>>Kocaeli</option>
              <option value="Konya" <?php if ($city == 'Konya') {
                                      echo "selected";
                                    } ?>>Konya</option>
              <option value="Kütahya" <?php if ($city == 'Kütahya') {
                                        echo "selected";
                                      } ?>>Kütahya</option>
              <option value="Malatya" <?php if ($city == 'Malatya') {
                                        echo "selected";
                                      } ?>>Malatya</option>
              <option value="Manisa" <?php if ($city == 'Manisa') {
                                        echo "selected";
                                      } ?>>Manisa</option>
              <option value="Kahramanmaraş" <?php if ($city == 'Kahramanmaraş') {
                                              echo "selected";
                                            } ?>>Kahramanmaraş</option>
              <option value="Mardin" <?php if ($city == 'Mardin') {
                                        echo "selected";
                                      } ?>>Mardin</option>
              <option value="Muğla" <?php if ($city == 'Muğla') {
                                      echo "selected";
                                    } ?>>Muğla</option>
              <option value="Muş" <?php if ($city == 'Muş') {
                                    echo "selected";
                                  } ?>>Muş</option>
              <option value="Nevşehir" <?php if ($city == 'Nevşehir') {
                                          echo "selected";
                                        } ?>>Nevşehir</option>
              <option value="Niğde" <?php if ($city == 'Niğde') {
                                      echo "selected";
                                    } ?>>Niğde</option>
              <option value="Ordu" <?php if ($city == 'Ordu') {
                                      echo "selected";
                                    } ?>>Ordu</option>
              <option value="Rize" <?php if ($city == 'Rize') {
                                      echo "selected";
                                    } ?>>Rize</option>
              <option value="Sakarya" <?php if ($city == 'Sakarya') {
                                        echo "selected";
                                      } ?>>Sakarya</option>
              <option value="Samsun" <?php if ($city == 'Samsun') {
                                        echo "selected";
                                      } ?>>Samsun</option>
              <option value="Siirt" <?php if ($city == 'Siirt') {
                                      echo "selected";
                                    } ?>>Siirt</option>
              <option value="Sinop" <?php if ($city == 'Sinop') {
                                      echo "selected";
                                    } ?>>Sinop</option>
              <option value="Sivas" <?php if ($city == 'Sivas') {
                                      echo "selected";
                                    } ?>>Sivas</option>
              <option value="Tekirdağ" <?php if ($city == 'Tekirdağ') {
                                          echo "selected";
                                        } ?>>Tekirdağ</option>
              <option value="Tokat" <?php if ($city == 'Tokat') {
                                      echo "selected";
                                    } ?>>Tokat</option>
              <option value="Trabzon" <?php if ($city == 'Trabzon') {
                                        echo "selected";
                                      } ?>>Trabzon</option>
              <option value="Tunceli" <?php if ($city == 'Tunceli') {
                                        echo "selected";
                                      } ?>>Tunceli</option>
              <option value="Şanlıurfa" <?php if ($city == 'Şanlıurfa') {
                                          echo "selected";
                                        } ?>>Şanlıurfa</option>
              <option value="Uşak" <?php if ($city == 'Uşak') {
                                      echo "selected";
                                    } ?>>Uşak</option>
              <option value="Van" <?php if ($city == 'Van') {
                                    echo "selected";
                                  } ?>>Van</option>
              <option value="Yozgat" <?php if ($city == 'Yozgat') {
                                        echo "selected";
                                      } ?>>Yozgat</option>
              <option value="Zonguldak" <?php if ($city == 'Zonguldak') {
                                          echo "selected";
                                        } ?>>Zonguldak</option>
              <option value="Aksaray" <?php if ($city == 'Aksaray') {
                                        echo "selected";
                                      } ?>>Aksaray</option>
              <option value="Bayburt" <?php if ($city == 'Bayburt') {
                                        echo "selected";
                                      } ?>>Bayburt</option>
              <option value="Karaman" <?php if ($city == 'Karaman') {
                                        echo "selected";
                                      } ?>>Karaman</option>
              <option value="Kırıkkale" <?php if ($city == 'Kırıkkale') {
                                          echo "selected";
                                        } ?>>Kırıkkale</option>
              <option value="Batman" <?php if ($city == 'Batman') {
                                        echo "selected";
                                      } ?>>Batman</option>
              <option value="Şırnak" <?php if ($city == 'Şırnak') {
                                        echo "selected";
                                      } ?>>Şırnak</option>
              <option value="Bartın" <?php if ($city == 'Bartın') {
                                        echo "selected";
                                      } ?>>Bartın</option>
              <option value="Ardahan" <?php if ($city == 'Ardahan') {
                                        echo "selected";
                                      } ?>>Ardahan</option>
              <option value="Iğdır" <?php if ($city == 'Iğdır') {
                                      echo "selected";
                                    } ?>>Iğdır</option>
              <option value="Yalova" <?php if ($city == 'Yalova') {
                                        echo "selected";
                                      } ?>>Yalova</option>
              <option value="Karabük" <?php if ($city == 'Karabük') {
                                        echo "selected";
                                      } ?>>Karabük</option>
              <option value="Kilis" <?php if ($city == 'Kilis') {
                                      echo "selected";
                                    } ?>>Kilis</option>
              <option value="Osmaniye" <?php if ($city == 'Osmaniye') {
                                          echo "selected";
                                        } ?>>Osmaniye</option>
              <option value="Düzce" <?php if ($city == 'Düzce') {
                                      echo "selected";
                                    } ?>>Düzce</option>
            </select>
            <span class="input-group-addon"><i class="fa fa-home"></i></span>
          </div>
        </div>
      </div>
      <!-- Button -->
      <div class="form-group">
        <label class="col-md-4 control-label"></label>
        <div class="col-md-4" style="text-align:right"><br>
          <input type="submit" class="btn" style="background-color: #7386D5;width:40%;color:white" name="update">
        </div>
      </div>
    </form>
  </section>
  <script src="script.js"></script>
</body>

</html>