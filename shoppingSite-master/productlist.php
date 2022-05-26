<?php include "header.php";
?>
<?php
include "db.php";
$conn = OpenCon();
error_reporting(0);
$grupid;
$Grup = null;
//bunlar da default da yazılacak değerler
$values = array();
$values2 = array();
$values3 = array();
$values4 = array();
$type_durum = null;
$type_day = null;
//sorgu için yazılacaklar
$state = "";
$tarih = "";
$sehir = "";
$marka = "";
$alan = "";
$yılı = "";
$price = "";
$min = null;
$max = null;
$sql_sorgusu = "SELECT * FROM adword_list WHERE is_active = 1 ";
$Grup = $_GET['Grup'];

if ($Grup == '' || $Grup == null) {
  $baslik = "Ürünler";
  $grupid = 0;
} else {
  if ($Grup == 'Lastik') {
    $grupid = 1;
  } else if ($Grup == 'Akü') {
    $grupid = 2;
  } else {
    $grupid = 3;
  }
  $baslik = $Grup;
}
if ($baslik != 'Ürünler') {
  $sql_sorgusu = $sql_sorgusu . " AND category_list_id = $grupid ";
}

if (isset($_POST['ara']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
  $price = "";
  $min = $_POST['min1'];
  $max = $_POST['max1'];
  if ($min != null) {
    $price = " AND price >= $min ";
  }
  if ($max != null) {
    $price = $price . " AND price <= $max ";
  }
  if (!empty($_POST['radio'])) {
    $type_durum = $_POST['radio'];
    //burda ürünün durumuna göre filtreliyor
    $state = " AND adword_state = $type_durum ";
  }
  if (!empty($_POST['radio1'])) {
    $type_day = $_POST['radio1'];
    //burada da tarihe göre filtre yapıyoz
    $tarih = " AND create_date >= DATE_SUB(CURDATE(), INTERVAL $type_day DAY) ";
  }
  if (!empty($_POST['city'])) {
    $values = $_POST['city'];
    $sayac = 0;
    foreach ($values as $a) {
      if ($sayac == 0) {
        $sehir = " AND  ( city = '" . $a . "'";
      } else {
        $sehir = $sehir . " OR city = '" . $a . "'";
      }
      $sayac++;
    }
    $sehir = $sehir . " )";
  } else {
    $sehir = "";
  }
  if (!empty($_POST['marka'])) {
    $values2 = $_POST['marka'];
    $sayac = 0;
    foreach ($values2 as $a) {
      if ($sayac == 0) {
        $marka = " AND ( adword_marka = " . $a;
      } else {
        $marka = $marka . " OR adword_marka = " . $a;
      }
      $sayac++;
    }
    $marka = $marka . " )";
  } else {
    $marka = "";
  }
  if (!empty($_POST['alan'])) {
    $values3 = $_POST['alan'];
    $sayac = 0;
    foreach ($values3 as $a) {
      if ($sayac == 0) {
        $alan = " AND ( adword_kullanım_yeri = " . $a;
      } else {
        $alan = $alan . " OR adword_kullanım_yeri = " . $a;
      }
      $sayac++;
    }
    $alan = $alan . " )";
  } else {
    $alan = "";
  }

  if (!empty($_POST['yılı'])) {
    $values4 = $_POST['yılı'];
    $sayac = 0;
    foreach ($values4 as $a) {
      if ($sayac == 0) {
        $yılı = " AND ( adword_ebat = " . $a;
      } else {
        $yılı = $yılı . " OR adword_ebat = " . $a;
      }
      $sayac++;
    }
    $yılı = $yılı . " ) ";
  } else {
    $yılı = "";
  }
}


?>
<style>
  body {
    position: relative;
    overflow-x: scroll !important;

  }



  .button {
    border: none;
    color: white;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    padding: 2.5%;
    cursor: pointer;
  }


  table {
    table-layout: fixed;
  }

  .first {
    width: 250px;
  }

  .ellipsis {
    position: relative;
  }

  .ellipsis:before {
    content: '&nbsp;';
    visibility: hidden;
  }

  .ellipsis span {
    position: absolute;
    left: 0;
    right: 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }


  @media screen and (max-width: 760px) {

    #header {
      width: 1215px;
      display: flex;
      flex-wrap: wrap;
    }

    #topbar {
      width: 1215px;
    }

    #list {
      width: 1200px;
    }

  }
</style>

<body>
  <main style="padding: 3%; font-size:smaller">
    <div class="container-fluid" id="list">
      <div class="row">
        <div class="col-3">
          <!-- burası filtreleme yeri-->
          <div style="background-color:#f5f5f5;padding:3%">
            <h3>
              <?php echo $baslik;   ?>
            </h3>
          </div>
          <br>
          <hr> <br>
          <form action="" method="post" enctype="multipart/form-data">

            <div style="background-color:#f5f5f5;padding:3%">
              <h6>Fiyat seçiniz </h6>
              <hr>
              <div>
                <input type="text" id="min" name="min1" value="<?php echo $min; ?>" style="width:40%;display:inline" placeholder="min.."> --
                <input type="text" id="max" name="max1" value="<?php echo $max; ?>" style="width:40%;display:inline" placeholder="max.."> TL
              </div>

            </div>

            <!--Şehir seçme bölümü-->
            <br>
            <hr style="height:1px;border-width:0;color:gray;background-color:gray"> <br>
            <div class="form-group" style="background-color:#f5f5f5;padding:4%">
              <h6 style="display:inline">İlleri seçiniz</h6><br>
              <p style="padding-top:10px">
                <select class="selectpicker form-control" multiple data-live-search="true" name="city[]">
                  <option value="none" selected="" disabled="">İl</option>
                  <option value="Adana" <?php if (in_array('Adana', $values)) {
                                          echo "selected";
                                        } ?>>Adana</option>
                  <option value="Adıyaman" <?php if (in_array('Adıyaman', $values)) {
                                              echo "selected";
                                            } ?>>Adıyaman</option>
                  <option value="Afyonkarahisar" <?php if (in_array('Afyonkarahisar', $values)) {
                                                    echo "selected";
                                                  } ?>>Afyonkarahisar</option>
                  <option value="Ağrı" <?php if (in_array('Ağrı', $values)) {
                                          echo "selected";
                                        } ?>>Ağrı</option>
                  <option value="Amasya" <?php if (in_array('Amasya', $values)) {
                                            echo "selected";
                                          } ?>>Amasya</option>
                  <option value="Ankara" <?php if (in_array('Ankara', $values)) {
                                            echo "selected";
                                          } ?>>Ankara</option>
                  <option value="Antalya" <?php if (in_array('Antalya', $values)) {
                                            echo "selected";
                                          } ?>>Antalya</option>
                  <option value="Artvin" <?php if (in_array('Artvin', $values)) {
                                            echo "selected";
                                          } ?>>Artvin</option>
                  <option value="Aydın" <?php if (in_array('Aydın', $values)) {
                                          echo "selected";
                                        } ?>>Aydın</option>
                  <option value="Balıkesir" <?php if (in_array('Balıkesir', $values)) {
                                              echo "selected";
                                            } ?>>Balıkesir</option>
                  <option value="Bilecik" <?php if (in_array('Bilecik', $values)) {
                                            echo "selected";
                                          } ?>>Bilecik</option>
                  <option value="Bingöl" <?php if (in_array('Bingöl', $values)) {
                                            echo "selected";
                                          } ?>>Bingöl</option>
                  <option value="Bitlis" <?php if (in_array('Bitlis', $values)) {
                                            echo "selected";
                                          } ?>>Bitlis</option>
                  <option value="Bolu" <?php if (in_array('Bolu', $values)) {
                                          echo "selected";
                                        } ?>>Bolu</option>
                  <option value="Burdur" <?php if (in_array('Burdur', $values)) {
                                            echo "selected";
                                          } ?>>Burdur</option>
                  <option value="Bursa" <?php if (in_array('Bursa', $values)) {
                                          echo "selected";
                                        } ?>>Bursa</option>
                  <option value="Çanakkale" <?php if (in_array('Çanakkale', $values)) {
                                              echo "selected";
                                            } ?>>Çanakkale</option>
                  <option value="Çankırı" <?php if (in_array('Çankırı', $values)) {
                                            echo "selected";
                                          } ?>>Çankırı</option>
                  <option value="Çorum" <?php if (in_array('Çorum', $values)) {
                                          echo "selected";
                                        } ?>>Çorum</option>
                  <option value="Denizli" <?php if (in_array('Denizli', $values)) {
                                            echo "selected";
                                          } ?>>Denizli</option>
                  <option value="Diyarbakır" <?php if (in_array('Diyarbakır', $values)) {
                                                echo "selected";
                                              } ?>>Diyarbakır</option>
                  <option value="Edirne" <?php if (in_array('Edirne', $values)) {
                                            echo "selected";
                                          } ?>>Edirne</option>
                  <option value="Elazığ" <?php if (in_array('Elazığ', $values)) {
                                            echo "selected";
                                          } ?>>Elazığ</option>
                  <option value="Erzincan" <?php if (in_array('Erzincan', $values)) {
                                              echo "selected";
                                            } ?>>Erzincan</option>
                  <option value="Erzurum" <?php if (in_array('Erzurum', $values)) {
                                            echo "selected";
                                          } ?>>Erzurum</option>
                  <option value="Eskişehir" <?php if (in_array('Eskişehir', $values)) {
                                              echo "selected";
                                            } ?>>Eskişehir</option>
                  <option value="Gaziantep" <?php if (in_array('Gaziantep', $values)) {
                                              echo "selected";
                                            } ?>>Gaziantep</option>
                  <option value="Giresun" <?php if (in_array('Giresun', $values)) {
                                            echo "selected";
                                          } ?>>Giresun</option>
                  <option value="Gümüşhane" <?php if (in_array('Gümüşhane', $values)) {
                                              echo "selected";
                                            } ?>>Gümüşhane</option>
                  <option value="Hakkari" <?php if (in_array('Hakkari', $values)) {
                                            echo "selected";
                                          } ?>>Hakkâri</option>
                  <option value="Hatay" <?php if (in_array('Hatay', $values)) {
                                          echo "selected";
                                        } ?>>Hatay</option>
                  <option value="Isparta" <?php if (in_array('Isparta', $values)) {
                                            echo "selected";
                                          } ?>>Isparta</option>
                  <option value="Mersin" <?php if (in_array('Mersin', $values)) {
                                            echo "selected";
                                          } ?>>Mersin</option>
                  <option value="İstanbul" <?php if (in_array('İstanbul', $values)) {
                                              echo "selected";
                                            } ?>>İstanbul</option>
                  <option value="İzmir" <?php if (in_array('İzmir', $values)) {
                                          echo "selected";
                                        } ?>>İzmir</option>
                  <option value="Kars" <?php if (in_array('Kars', $values)) {
                                          echo "selected";
                                        } ?>>Kars</option>
                  <option value="Kastamonu" <?php if (in_array('Kastamonu', $values)) {
                                              echo "selected";
                                            } ?>>Kastamonu</option>
                  <option value="Kayseri" <?php if (in_array('Kayseri', $values)) {
                                            echo "selected";
                                          } ?>>Kayseri</option>
                  <option value="Kırklareli" <?php if (in_array('Kırklareli', $values)) {
                                                echo "selected";
                                              } ?>>Kırklareli</option>
                  <option value="Kırşehir" <?php if (in_array('Kırşehir', $values)) {
                                              echo "selected";
                                            } ?>>Kırşehir</option>
                  <option value="Kocaeli" <?php if (in_array('Kocaeli', $values)) {
                                            echo "selected";
                                          } ?>>Kocaeli</option>
                  <option value="Konya" <?php if (in_array('Konya', $values)) {
                                          echo "selected";
                                        } ?>>Konya</option>
                  <option value="Kütahya" <?php if (in_array('Kütahya', $values)) {
                                            echo "selected";
                                          } ?>>Kütahya</option>
                  <option value="Malatya" <?php if (in_array('Malatya', $values)) {
                                            echo "selected";
                                          } ?>>Malatya</option>
                  <option value="Manisa" <?php if (in_array('Manisa', $values)) {
                                            echo "selected";
                                          } ?>>Manisa</option>
                  <option value="Kahramanmaraş" <?php if (in_array('Kahramanmaraş', $values)) {
                                                  echo "selected";
                                                } ?>>Kahramanmaraş</option>
                  <option value="Mardin" <?php if (in_array('Mardin', $values)) {
                                            echo "selected";
                                          } ?>>Mardin</option>
                  <option value="Muğla" <?php if (in_array('Muğla', $values)) {
                                          echo "selected";
                                        } ?>>Muğla</option>
                  <option value="Muş" <?php if (in_array('Muş', $values)) {
                                        echo "selected";
                                      } ?>>Muş</option>
                  <option value="Nevşehir" <?php if (in_array('Nevşehir', $values)) {
                                              echo "selected";
                                            } ?>>Nevşehir</option>
                  <option value="Niğde" <?php if (in_array('Niğde', $values)) {
                                          echo "selected";
                                        } ?>>Niğde</option>
                  <option value="Ordu" <?php if (in_array('Ordu', $values)) {
                                          echo "selected";
                                        } ?>>Ordu</option>
                  <option value="Rize" <?php if (in_array('Rize', $values)) {
                                          echo "selected";
                                        } ?>>Rize</option>
                  <option value="Sakarya" <?php if (in_array('Sakarya', $values)) {
                                            echo "selected";
                                          } ?>>Sakarya</option>
                  <option value="Samsun" <?php if (in_array('Samsun', $values)) {
                                            echo "selected";
                                          } ?>>Samsun</option>
                  <option value="Siirt" <?php if (in_array('Siirt', $values)) {
                                          echo "selected";
                                        } ?>>Siirt</option>
                  <option value="Sinop" <?php if (in_array('Sinop', $values)) {
                                          echo "selected";
                                        } ?>>Sinop</option>
                  <option value="Sivas" <?php if (in_array('Sivas', $values)) {
                                          echo "selected";
                                        } ?>>Sivas</option>
                  <option value="Tekirdağ" <?php if (in_array('Tekirdağ', $values)) {
                                              echo "selected";
                                            } ?>>Tekirdağ</option>
                  <option value="Tokat" <?php if (in_array('Tokat', $values)) {
                                          echo "selected";
                                        } ?>>Tokat</option>
                  <option value="Trabzon" <?php if (in_array('Trabzon', $values)) {
                                            echo "selected";
                                          } ?>>Trabzon</option>
                  <option value="Tunceli" <?php if (in_array('Tunceli', $values)) {
                                            echo "selected";
                                          } ?>>Tunceli</option>
                  <option value="Şanlıurfa" <?php if (in_array('Şanlıurfa', $values)) {
                                              echo "selected";
                                            } ?>>Şanlıurfa</option>
                  <option value="Uşak" <?php if (in_array('Uşak', $values)) {
                                          echo "selected";
                                        } ?>>Uşak</option>
                  <option value="Van" <?php if (in_array('Van', $values)) {
                                        echo "selected";
                                      } ?>>Van</option>
                  <option value="Yozgat" <?php if (in_array('Yozgat', $values)) {
                                            echo "selected";
                                          } ?>>Yozgat</option>
                  <option value="Zonguldak" <?php if (in_array('Zonguldak', $values)) {
                                              echo "selected";
                                            } ?>>Zonguldak</option>
                  <option value="Aksaray" <?php if (in_array('Aksaray', $values)) {
                                            echo "selected";
                                          } ?>>Aksaray</option>
                  <option value="Bayburt" <?php if (in_array('Bayburt', $values)) {
                                            echo "selected";
                                          } ?>>Bayburt</option>
                  <option value="Karaman" <?php if (in_array('Karaman', $values)) {
                                            echo "selected";
                                          } ?>>Karaman</option>
                  <option value="Kırıkkale" <?php if (in_array('Kırıkkale', $values)) {
                                              echo "selected";
                                            } ?>>Kırıkkale</option>
                  <option value="Batman" <?php if (in_array('Batman', $values)) {
                                            echo "selected";
                                          } ?>>Batman</option>
                  <option value="Şırnak" <?php if (in_array('Şırnak', $values)) {
                                            echo "selected";
                                          } ?>>Şırnak</option>
                  <option value="Bartın" <?php if (in_array('Bartın', $values)) {
                                            echo "selected";
                                          } ?>>Bartın</option>
                  <option value="Ardahan" <?php if (in_array('Ardahan', $values)) {
                                            echo "selected";
                                          } ?>>Ardahan</option>
                  <option value="Iğdır" <?php if (in_array('Iğdır', $values)) {
                                          echo "selected";
                                        } ?>>Iğdır</option>
                  <option value="Yalova" <?php if (in_array('Yalova', $values)) {
                                            echo "selected";
                                          } ?>>Yalova</option>
                  <option value="Karabük" <?php if (in_array('Karabük', $values)) {
                                            echo "selected";
                                          } ?>>Karabük</option>
                  <option value="Kilis" <?php if (in_array('Kilis', $values)) {
                                          echo "selected";
                                        } ?>>Kilis</option>
                  <option value="Osmaniye" <?php if (in_array('Osmaniye', $values)) {
                                              echo "selected";
                                            } ?>>Osmaniye</option>
                  <option value="Düzce" <?php if (in_array('Düzce', $values)) {
                                          echo "selected";
                                        } ?>>Düzce</option>
                </select>
              </p>
            </div>
            <!--Marka seçme bölümü-->
            <br>
            <hr style="height:1px;border-width:0;color:gray;background-color:gray"> <br>
            <div class="form-group" style="background-color:#f5f5f5;padding:4%">
              <h6 style="display:inline">Marka Seçiniz</h6>
              <h6 style="display:inline"></h6> <br>
              <p style="padding-top:10px">
                <select class="selectpicker form-control" multiple data-live-search="true" name="marka[]">
                  <option value="none" selected="" disabled="">Markalar</option>
                  <?php if ($grupid=1 || $grupid==3) { ?>
                    <option value="1" <?php if (in_array('1', $values2)) {
                                        echo "selected";
                                      } ?>>Achilles</option>
                    <option value="2" <?php if (in_array('2', $values2)) {
                                        echo "selected";
                                      } ?>>Addo India</option>
                    <option value="3" <?php if (in_array('3', $values2)) {
                                        echo "selected";
                                      } ?>>Aeolus</option>
                    <option value="4" <?php if (in_array('4', $values2)) {
                                        echo "selected";
                                      } ?>>Agate</option>
                    <option value="5" <?php if (in_array('5', $values2)) {
                                        echo "selected";
                                      } ?>>AJS</option>
                    <option value="6" <?php if (in_array('6', $values2)) {
                                        echo "selected";
                                      } ?>>Alan</option>
                    <option value="7" <?php if (in_array('7', $values2)) {
                                        echo "selected";
                                      } ?>>Alliance</option>
                    <option value="8" <?php if (in_array('8', $values2)) {
                                        echo "selected";
                                      } ?>>Altenzo</option>
                    <option value="9" <?php if (in_array('9', $values2)) {
                                        echo "selected";
                                      } ?>>Altura</option>
                    <option value="10" <?php if (in_array('10', $values2)) {
                                          echo "selected";
                                        } ?>>Amp Tires</option>
                    <option value="11" <?php if (in_array('11', $values2)) {
                                          echo "selected";
                                        } ?>>Amtel</option>
                    <option value="12" <?php if (in_array('12', $values2)) {
                                          echo "selected";
                                        } ?>>Anlas</option>
                    <option value="13" <?php if (in_array('13', $values2)) {
                                          echo "selected";
                                        } ?>>Annaite</option>
                    <option value="14" <?php if (in_array('14', $values2)) {
                                          echo "selected";
                                        } ?>>Antares</option>
                    <option value="15" <?php if (in_array('15', $values2)) {
                                          echo "selected";
                                        } ?>>Anteo</option>
                    <option value="16" <?php if (in_array('16', $values2)) {
                                          echo "selected";
                                        } ?>>Aoteli</option>
                    <option value="17" <?php if (in_array('17', $values2)) {
                                          echo "selected";
                                        } ?>>Aplus</option>
                    <option value="18" <?php if (in_array('18', $values2)) {
                                          echo "selected";
                                        } ?>>Apollo</option>
                    <option value="19" <?php if (in_array('19', $values2)) {
                                          echo "selected";
                                        } ?>>Aptany</option>
                    <option value="20" <?php if (in_array('20', $values2)) {
                                          echo "selected";
                                        } ?>>Arestone</option>
                    <option value="21" <?php if (in_array('21', $values2)) {
                                          echo "selected";
                                        } ?>>Armforce</option>
                    <option value="22" <?php if (in_array('22', $values2)) {
                                          echo "selected";
                                        } ?>>Armstrong</option>
                    <option value="23" <?php if (in_array('23', $values2)) {
                                          echo "selected";
                                        } ?>>Arora</option>
                    <option value="24" <?php if (in_array('24', $values2)) {
                                          echo "selected";
                                        } ?>>Artum</option>
                    <option value="25" <?php if (in_array('25', $values2)) {
                                          echo "selected";
                                        } ?>>Asya</option>
                    <option value="26" <?php if (in_array('26', $values2)) {
                                          echo "selected";
                                        } ?>>Atlas</option>
                    <option value="27" <?php if (in_array('27', $values2)) {
                                          echo "selected";
                                        } ?>>Atrezzo</option>
                    <option value="28" <?php if (in_array('28', $values2)) {
                                          echo "selected";
                                        } ?>>Austone</option>
                    <option value="29" <?php if (in_array('29', $values2)) {
                                          echo "selected";
                                        } ?>>Autogrip</option>
                    <option value="30" <?php if (in_array('30', $values2)) {
                                          echo "selected";
                                        } ?>>Avenger</option>
                    <option value="31" <?php if (in_array('31', $values2)) {
                                          echo "selected";
                                        } ?>>Barez</option>
                    <option value="32" <?php if (in_array('32', $values2)) {
                                          echo "selected";
                                        } ?>>Barum</option>
                    <option value="33" <?php if (in_array('33', $values2)) {
                                          echo "selected";
                                        } ?>>Baysal</option>
                    <option value="34" <?php if (in_array('34', $values2)) {
                                          echo "selected";
                                        } ?>>Beestone</option>
                    <option value="35" <?php if (in_array('35', $values2)) {
                                          echo "selected";
                                        } ?>>Belshina</option>
                    <option value="36" <?php if (in_array('36', $values2)) {
                                          echo "selected";
                                        } ?>>BF Goodrich</option>
                    <option value="37" <?php if (in_array('37', $values2)) {
                                          echo "selected";
                                        } ?>>Billas</option>
                    <option value="38" <?php if (in_array('38', $values2)) {
                                          echo "selected";
                                        } ?>>BKT</option>
                    <option value="39" <?php if (in_array('39', $values2)) {
                                          echo "selected";
                                        } ?>>Blacklion</option>
                    <option value="40" <?php if (in_array('40', $values2)) {
                                          echo "selected";
                                        } ?>>Blackstone</option>
                    <option value="41" <?php if (in_array('41', $values2)) {
                                          echo "selected";
                                        } ?>>Blizzard</option>
                    <option value="42" <?php if (in_array('42', $values2)) {
                                          echo "selected";
                                        } ?>>Boğa Tyres</option>
                    <option value="43" <?php if (in_array('43', $values2)) {
                                          echo "selected";
                                        } ?>>Bonsun</option>
                    <option value="44" <?php if (in_array('44', $values2)) {
                                          echo "selected";
                                        } ?>>BossTire</option>
                    <option value="45" <?php if (in_array('45', $values2)) {
                                          echo "selected";
                                        } ?>>Boto</option>
                    <option value="46" <?php if (in_array('46', $values2)) {
                                          echo "selected";
                                        } ?>>Bravuris</option>
                    <option value="47" <?php if (in_array('47', $values2)) {
                                          echo "selected";
                                        } ?>>Bridgestone</option>
                    <option value="48" <?php if (in_array('48', $values2)) {
                                          echo "selected";
                                        } ?>>Brilliant</option>
                    <option value="49" <?php if (in_array('49', $values2)) {
                                          echo "selected";
                                        } ?>>Carbon Series</option>
                    <option value="50" <?php if (in_array('50', $values2)) {
                                          echo "selected";
                                        } ?>>Carlisle</option>
                    <option value="51" <?php if (in_array('51', $values2)) {
                                          echo "selected";
                                        } ?>>Catch Power</option>
                    <option value="52" <?php if (in_array('52', $values2)) {
                                          echo "selected";
                                        } ?>>Ceat Iseo</option>
                    <option value="53" <?php if (in_array('53', $values2)) {
                                          echo "selected";
                                        } ?>>Champiro</option>
                    <option value="54" <?php if (in_array('54', $values2)) {
                                          echo "selected";
                                        } ?>>Cheng Shin</option>
                    <option value="55" <?php if (in_array('55', $values2)) {
                                          echo "selected";
                                        } ?>>Chopper</option>
                    <option value="56" <?php if (in_array('56', $values2)) {
                                          echo "selected";
                                        } ?>>Comfort</option>
                    <option value="57" <?php if (in_array('57', $values2)) {
                                          echo "selected";
                                        } ?>>Compasal</option>
                    <option value="58" <?php if (in_array('58', $values2)) {
                                          echo "selected";
                                        } ?>>Constancy</option>
                    <option value="59" <?php if (in_array('59', $values2)) {
                                          echo "selected";
                                        } ?>>Continental</option>
                    <option value="60" <?php if (in_array('60', $values2)) {
                                          echo "selected";
                                        } ?>>Cooper</option>
                    <option value="61" <?php if (in_array('61', $values2)) {
                                          echo "selected";
                                        } ?>>Cordiant</option>
                    <option value="62" <?php if (in_array('62', $values2)) {
                                          echo "selected";
                                        } ?>>Courier</option>
                    <option value="63" <?php if (in_array('63', $values2)) {
                                          echo "selected";
                                        } ?>>Cratos</option>
                    <option value="64" <?php if (in_array('64', $values2)) {
                                          echo "selected";
                                        } ?>>Cultor</option>
                    <option value="65" <?php if (in_array('65', $values2)) {
                                          echo "selected";
                                        } ?>>Dayton</option>
                    <option value="66" <?php if (in_array('66', $values2)) {
                                          echo "selected";
                                        } ?>>Debica</option>
                    <option value="67" <?php if (in_array('67', $values2)) {
                                          echo "selected";
                                        } ?>>Deestone</option>
                    <option value="68" <?php if (in_array('68', $values2)) {
                                          echo "selected";
                                        } ?>>Delinte</option>
                    <option value="69" <?php if (in_array('69', $values2)) {
                                          echo "selected";
                                        } ?>>Delitire</option>
                    <option value="70" <?php if (in_array('70', $values2)) {
                                          echo "selected";
                                        } ?>>Deruibo</option>
                    <option value="71" <?php if (in_array('71', $values2)) {
                                          echo "selected";
                                        } ?>>Diplomat</option>
                    <option value="72" <?php if (in_array('72', $values2)) {
                                          echo "selected";
                                        } ?>>Dmack</option>
                    <option value="73" <?php if (in_array('73', $values2)) {
                                          echo "selected";
                                        } ?>>Dneproshina</option>
                    <option value="74" <?php if (in_array('74', $values2)) {
                                          echo "selected";
                                        } ?>>Doublestar</option>
                    <option value="75" <?php if (in_array('75', $values2)) {
                                          echo "selected";
                                        } ?>>Dunlop</option>
                    <option value="76" <?php if (in_array('76', $values2)) {
                                          echo "selected";
                                        } ?>>Blizzard</option>
                    <option value="77" <?php if (in_array('77', $values2)) {
                                          echo "selected";
                                        } ?>>Duraturn</option>
                    <option value="78" <?php if (in_array('78', $values2)) {
                                          echo "selected";
                                        } ?>>Duravis</option>
                    <option value="79" <?php if (in_array('79', $values2)) {
                                          echo "selected";
                                        } ?>>Duro</option>
                    <option value="80" <?php if (in_array('80', $values2)) {
                                          echo "selected";
                                        } ?>>Effiplus</option>
                    <option value="81" <?php if (in_array('81', $values2)) {
                                          echo "selected";
                                        } ?>>ERC</option>
                    <option value="82" <?php if (in_array('82', $values2)) {
                                          echo "selected";
                                        } ?>>Esa+Tecar</option>
                    <option value="83" <?php if (in_array('83', $values2)) {
                                          echo "selected";
                                        } ?>>Eurogrip</option>
                    <option value="84" <?php if (in_array('84', $values2)) {
                                          echo "selected";
                                        } ?>>Eurotyre</option>
                    <option value="85" <?php if (in_array('85', $values2)) {
                                          echo "selected";
                                        } ?>>Evergreen</option>
                    <option value="86" <?php if (in_array('86', $values2)) {
                                          echo "selected";
                                        } ?>>Evermax</option>
                    <option value="87" <?php if (in_array('87', $values2)) {
                                          echo "selected";
                                        } ?>>Falken</option>
                    <option value="88" <?php if (in_array('88', $values2)) {
                                          echo "selected";
                                        } ?>>Faralong</option>
                    <option value="89" <?php if (in_array('89', $values2)) {
                                          echo "selected";
                                        } ?>>Farroad</option>
                    <option value="90" <?php if (in_array('90', $values2)) {
                                          echo "selected";
                                        } ?>>Fate</option>
                    <option value="91" <?php if (in_array('91', $values2)) {
                                          echo "selected";
                                        } ?>>Federal</option>
                    <option value="92" <?php if (in_array('92', $values2)) {
                                          echo "selected";
                                        } ?>>Fedima</option>
                    <option value="93" <?php if (in_array('93', $values2)) {
                                          echo "selected";
                                        } ?>>Feu Vert</option>
                    <option value="94" <?php if (in_array('94', $values2)) {
                                          echo "selected";
                                        } ?>>Firenza</option>
                    <option value="95" <?php if (in_array('95', $values2)) {
                                          echo "selected";
                                        } ?>>FireStone</option>
                    <option value="96" <?php if (in_array('96', $values2)) {
                                          echo "selected";
                                        } ?>>Fisk</option>
                    <option value="97" <?php if (in_array('97', $values2)) {
                                          echo "selected";
                                        } ?>>Formula Energy</option>
                    <option value="98" <?php if (in_array('98', $values2)) {
                                          echo "selected";
                                        } ?>>Fronway</option>
                    <option value="99" <?php if (in_array('99', $values2)) {
                                          echo "selected";
                                        } ?>>Fulda</option>
                    <option value="100" <?php if (in_array('100', $values2)) {
                                          echo "selected";
                                        } ?>>Fullrun</option>
                    <option value="101" <?php if (in_array('101', $values2)) {
                                          echo "selected";
                                        } ?>>General Tire</option>
                    <option value="102" <?php if (in_array('102', $values2)) {
                                          echo "selected";
                                        } ?>>Geroni</option>
                    <option value="103" <?php if (in_array('103', $values2)) {
                                          echo "selected";
                                        } ?>>Gislaved</option>
                    <option value="104" <?php if (in_array('104', $values2)) {
                                          echo "selected";
                                        } ?>>Globe Star</option>
                    <option value="105" <?php if (in_array('105', $values2)) {
                                          echo "selected";
                                        } ?>>Goalstar</option>
                    <option value="106" <?php if (in_array('106', $values2)) {
                                          echo "selected";
                                        } ?>>Golden Bridge</option>
                    <option value="107" <?php if (in_array('107', $values2)) {
                                          echo "selected";
                                        } ?>>Goldline</option>
                    <option value="108" <?php if (in_array('108', $values2)) {
                                          echo "selected";
                                        } ?>>Goodrich</option>
                    <option value="109" <?php if (in_array('109', $values2)) {
                                          echo "selected";
                                        } ?>>Goodride</option>
                    <option value="110" <?php if (in_array('110', $values2)) {
                                          echo "selected";
                                        } ?>>Goodyear</option>
                    <option value="111" <?php if (in_array('111', $values2)) {
                                          echo "selected";
                                        } ?>>Greckster</option>
                    <option value="112" <?php if (in_array('112', $values2)) {
                                          echo "selected";
                                        } ?>>Greentrac</option>
                    <option value="113" <?php if (in_array('113', $values2)) {
                                          echo "selected";
                                        } ?>>Gremax</option>
                    <option value="114" <?php if (in_array('114', $values2)) {
                                          echo "selected";
                                        } ?>>Grenlander</option>
                    <option value="115" <?php if (in_array('115', $values2)) {
                                          echo "selected";
                                        } ?>>Gripmax</option>
                    <option value="116" <?php if (in_array('116', $values2)) {
                                          echo "selected";
                                        } ?>>GT Radial</option>
                    <option value="117" <?php if (in_array('117', $values2)) {
                                          echo "selected";
                                        } ?>>Haida</option>
                    <option value="118" <?php if (in_array('118', $values2)) {
                                          echo "selected";
                                        } ?>>Hankook</option>
                    <option value="119" <?php if (in_array('119', $values2)) {
                                          echo "selected";
                                        } ?>>Heidenau</option>
                    <option value="120" <?php if (in_array('120', $values2)) {
                                          echo "selected";
                                        } ?>>Hercules</option>
                    <option value="121" <?php if (in_array('121', $values2)) {
                                          echo "selected";
                                        } ?>>Hero</option>
                    <option value="122" <?php if (in_array('122', $values2)) {
                                          echo "selected";
                                        } ?>>Hifly</option>
                    <option value="123" <?php if (in_array('123', $values2)) {
                                          echo "selected";
                                        } ?>>Honda</option>
                    <option value="124" <?php if (in_array('124', $values2)) {
                                          echo "selected";
                                        } ?>>Hoosier</option>
                    <option value="125" <?php if (in_array('125', $values2)) {
                                          echo "selected";
                                        } ?>>Horng Fortune</option>
                    <option value="126" <?php if (in_array('126', $values2)) {
                                          echo "selected";
                                        } ?>>Hunter</option>
                    <option value="127" <?php if (in_array('127', $values2)) {
                                          echo "selected";
                                        } ?>>Imperial</option>
                    <option value="128" <?php if (in_array('128', $values2)) {
                                          echo "selected";
                                        } ?>>Infinity</option>
                    <option value="129" <?php if (in_array('129', $values2)) {
                                          echo "selected";
                                        } ?>>Insa Turbo</option>
                    <option value="130" <?php if (in_array('130', $values2)) {
                                          echo "selected";
                                        } ?>>Interco Tire</option>
                    <option value="131" <?php if (in_array('131', $values2)) {
                                          echo "selected";
                                        } ?>>Intertrac</option>
                    <option value="132" <?php if (in_array('132', $values2)) {
                                          echo "selected";
                                        } ?>>IRC</option>
                    <option value="133" <?php if (in_array('133', $values2)) {
                                          echo "selected";
                                        } ?>>Italmatic</option>
                    <option value="134" <?php if (in_array('134', $values2)) {
                                          echo "selected";
                                        } ?>>ITP</option>
                    <option value="135" <?php if (in_array('135', $values2)) {
                                          echo "selected";
                                        } ?>>Jinyu</option>
                    <option value="136" <?php if (in_array('136', $values2)) {
                                          echo "selected";
                                        } ?>>JK Tyre</option>
                    <option value="137" <?php if (in_array('137', $values2)) {
                                          echo "selected";
                                        } ?>>Joyroad</option>
                    <option value="138" <?php if (in_array('138', $values2)) {
                                          echo "selected";
                                        } ?>>Kama</option>
                    <option value="139" <?php if (in_array('139', $values2)) {
                                          echo "selected";
                                        } ?>>Kapsen</option>
                    <option value="140" <?php if (in_array('140', $values2)) {
                                          echo "selected";
                                        } ?>>Kelly</option>
                    <option value="141" <?php if (in_array('141', $values2)) {
                                          echo "selected";
                                        } ?>>Kenda</option>
                    <option value="142" <?php if (in_array('142', $values2)) {
                                          echo "selected";
                                        } ?>>Kenex</option>
                    <option value="143" <?php if (in_array('143', $values2)) {
                                          echo "selected";
                                        } ?>>Keter</option>
                    <option value="144" <?php if (in_array('144', $values2)) {
                                          echo "selected";
                                        } ?>>Kinforest</option>
                    <option value="145" <?php if (in_array('145', $values2)) {
                                          echo "selected";
                                        } ?>>Kingstar</option>
                    <option value="146" <?php if (in_array('146', $values2)) {
                                          echo "selected";
                                        } ?>>Kleber</option>
                    <option value="147" <?php if (in_array('147', $values2)) {
                                          echo "selected";
                                        } ?>>Koçlas</option>
                    <option value="148" <?php if (in_array('148', $values2)) {
                                          echo "selected";
                                        } ?>>Kooler</option>
                    <option value="149" <?php if (in_array('149', $values2)) {
                                          echo "selected";
                                        } ?>>Kormoran</option>
                    <option value="150" <?php if (in_array('150', $values2)) {
                                          echo "selected";
                                        } ?>>KRM</option>
                    <option value="151" <?php if (in_array('151', $values2)) {
                                          echo "selected";
                                        } ?>>Kumho</option>
                    <option value="152" <?php if (in_array('152', $values2)) {
                                          echo "selected";
                                        } ?>>Landsail</option>
                    <option value="153" <?php if (in_array('153', $values2)) {
                                          echo "selected";
                                        } ?>>Lanvigator</option>
                    <option value="154" <?php if (in_array('154', $values2)) {
                                          echo "selected";
                                        } ?>>Lassa</option>
                    <option value="155" <?php if (in_array('155', $values2)) {
                                          echo "selected";
                                        } ?>>Laufenn</option>
                    <option value="156" <?php if (in_array('156', $values2)) {
                                          echo "selected";
                                        } ?>>Linglong</option>
                    <option value="157" <?php if (in_array('157', $values2)) {
                                          echo "selected";
                                        } ?>>Luhe</option>
                    <option value="158" <?php if (in_array('158', $values2)) {
                                          echo "selected";
                                        } ?>>Mabor</option>
                    <option value="159" <?php if (in_array('159', $values2)) {
                                          echo "selected";
                                        } ?>>Marangoni</option>
                    <option value="160" <?php if (in_array('160', $values2)) {
                                          echo "selected";
                                        } ?>>Marshall</option>
                    <option value="161" <?php if (in_array('161', $values2)) {
                                          echo "selected";
                                        } ?>>Mastercraft</option>
                    <option value="162" <?php if (in_array('162', $values2)) {
                                          echo "selected";
                                        } ?>>Matador</option>
                    <option value="163" <?php if (in_array('163', $values2)) {
                                          echo "selected";
                                        } ?>>Maxam</option>
                    <option value="164" <?php if (in_array('164', $values2)) {
                                          echo "selected";
                                        } ?>>Maxima</option>
                    <option value="165" <?php if (in_array('165', $values2)) {
                                          echo "selected";
                                        } ?>>Maxtrek</option>
                    <option value="166" <?php if (in_array('166', $values2)) {
                                          echo "selected";
                                        } ?>>Maxxis</option>
                    <option value="167" <?php if (in_array('167', $values2)) {
                                          echo "selected";
                                        } ?>>Mazzini</option>
                    <option value="168" <?php if (in_array('168', $values2)) {
                                          echo "selected";
                                        } ?>>Membat</option>
                    <option value="169" <?php if (in_array('169', $values2)) {
                                          echo "selected";
                                        } ?>>Mentor</option>
                    <option value="170" <?php if (in_array('170', $values2)) {
                                          echo "selected";
                                        } ?>>Metzeler</option>
                    <option value="171" <?php if (in_array('171', $values2)) {
                                          echo "selected";
                                        } ?>>Michelin</option>
                    <option value="172" <?php if (in_array('172', $values2)) {
                                          echo "selected";
                                        } ?>>Mickey Thompson</option>
                    <option value="173" <?php if (in_array('173', $values2)) {
                                          echo "selected";
                                        } ?>>Milestone</option>
                    <option value="174" <?php if (in_array('174', $values2)) {
                                          echo "selected";
                                        } ?>>Millennium</option>
                    <option value="175" <?php if (in_array('175', $values2)) {
                                          echo "selected";
                                        } ?>>Minerva</option>
                    <option value="176" <?php if (in_array('176', $values2)) {
                                          echo "selected";
                                        } ?>>Minnell</option>
                    <option value="177" <?php if (in_array('177', $values2)) {
                                          echo "selected";
                                        } ?>>Mitas</option>
                    <option value="178" <?php if (in_array('178', $values2)) {
                                          echo "selected";
                                        } ?>>Mohawk</option>
                    <option value="179" <?php if (in_array('179', $values2)) {
                                          echo "selected";
                                        } ?>>Momo</option>
                    <option value="180" <?php if (in_array('180', $values2)) {
                                          echo "selected";
                                        } ?>>Motrio</option>
                    <option value="181" <?php if (in_array('181', $values2)) {
                                          echo "selected";
                                        } ?>>MRF</option>
                    <option value="182" <?php if (in_array('182', $values2)) {
                                          echo "selected";
                                        } ?>>Mudstar</option>
                    <option value="183" <?php if (in_array('183', $values2)) {
                                          echo "selected";
                                        } ?>>Nankang</option>
                    <option value="184" <?php if (in_array('184', $values2)) {
                                          echo "selected";
                                        } ?>>Neuton</option>
                    <option value="185" <?php if (in_array('185', $values2)) {
                                          echo "selected";
                                        } ?>>Nexen</option>
                    <option value="186" <?php if (in_array('186', $values2)) {
                                          echo "selected";
                                        } ?>>Nitto</option>
                    <option value="187" <?php if (in_array('187', $values2)) {
                                          echo "selected";
                                        } ?>>Nokian</option>
                    <option value="188" <?php if (in_array('188', $values2)) {
                                          echo "selected";
                                        } ?>>Nordexx</option>
                    <option value="189" <?php if (in_array('189', $values2)) {
                                          echo "selected";
                                        } ?>>Numa</option>
                    <option value="190" <?php if (in_array('190', $values2)) {
                                          echo "selected";
                                        } ?>>Orium</option>
                    <option value="191" <?php if (in_array('191', $values2)) {
                                          echo "selected";
                                        } ?>>Ornet</option>
                    <option value="192" <?php if (in_array('192', $values2)) {
                                          echo "selected";
                                        } ?>>Otani</option>
                    <option value="193" <?php if (in_array('193', $values2)) {
                                          echo "selected";
                                        } ?>>Ovation</option>
                    <option value="194" <?php if (in_array('194', $values2)) {
                                          echo "selected";
                                        } ?>>Özka</option>
                    <option value="195" <?php if (in_array('195', $values2)) {
                                          echo "selected";
                                        } ?>>Pace</option>
                    <option value="196" <?php if (in_array('196', $values2)) {
                                          echo "selected";
                                        } ?>>Petlas</option>
                    <option value="197" <?php if (in_array('197', $values2)) {
                                          echo "selected";
                                        } ?>>Pirelli</option>
                    <option value="198" <?php if (in_array('198', $values2)) {
                                          echo "selected";
                                        } ?>>Planet</option>
                    <option value="199" <?php if (in_array('199', $values2)) {
                                          echo "selected";
                                        } ?>>Platin</option>
                    <option value="200" <?php if (in_array('200', $values2)) {
                                          echo "selected";
                                        } ?>>Pneumant</option>
                    <option value="201" <?php if (in_array('201', $values2)) {
                                          echo "selected";
                                        } ?>>Point S</option>
                    <option value="202" <?php if (in_array('202', $values2)) {
                                          echo "selected";
                                        } ?>>Pola</option>
                    <option value="203" <?php if (in_array('203', $values2)) {
                                          echo "selected";
                                        } ?>>Powerstone</option>
                    <option value="204" <?php if (in_array('204', $values2)) {
                                          echo "selected";
                                        } ?>>PowerTrac</option>
                    <option value="205" <?php if (in_array('205', $values2)) {
                                          echo "selected";
                                        } ?>>Premiorri</option>
                    <option value="206" <?php if (in_array('206', $values2)) {
                                          echo "selected";
                                        } ?>>Presa</option>
                    <option value="207" <?php if (in_array('207', $values2)) {
                                          echo "selected";
                                        } ?>>Primewell</option>
                    <option value="208" <?php if (in_array('208', $values2)) {
                                          echo "selected";
                                        } ?>>Radar</option>
                    <option value="209" <?php if (in_array('209', $values2)) {
                                          echo "selected";
                                        } ?>>Radial</option>
                    <option value="210" <?php if (in_array('210', $values2)) {
                                          echo "selected";
                                        } ?>>Raiden Tires</option>
                    <option value="211" <?php if (in_array('211', $values2)) {
                                          echo "selected";
                                        } ?>>Regal</option>
                    <option value="212" <?php if (in_array('212', $values2)) {
                                          echo "selected";
                                        } ?>>Riken</option>
                    <option value="213" <?php if (in_array('213', $values2)) {
                                          echo "selected";
                                        } ?>>Roadcruza</option>
                    <option value="214" <?php if (in_array('214', $values2)) {
                                          echo "selected";
                                        } ?>>Roadstone</option>
                    <option value="215" <?php if (in_array('215', $values2)) {
                                          echo "selected";
                                        } ?>>Rosava</option>
                    <option value="216" <?php if (in_array('216', $values2)) {
                                          echo "selected";
                                        } ?>>Rotalla</option>
                    <option value="217" <?php if (in_array('217', $values2)) {
                                          echo "selected";
                                        } ?>>Rotex</option>
                    <option value="218" <?php if (in_array('218', $values2)) {
                                          echo "selected";
                                        } ?>>Royal Black</option>
                    <option value="219" <?php if (in_array('219', $values2)) {
                                          echo "selected";
                                        } ?>>Rubber King</option>
                    <option value="220" <?php if (in_array('220', $values2)) {
                                          echo "selected";
                                        } ?>>Runway</option>
                    <option value="221" <?php if (in_array('221', $values2)) {
                                          echo "selected";
                                        } ?>>Saferich</option>
                    <option value="222" <?php if (in_array('222', $values2)) {
                                          echo "selected";
                                        } ?>>Sailun</option>
                    <option value="223" <?php if (in_array('223', $values2)) {
                                          echo "selected";
                                        } ?>>Sakura</option>
                    <option value="224" <?php if (in_array('224', $values2)) {
                                          echo "selected";
                                        } ?>>Sava</option>
                    <option value="225" <?php if (in_array('225', $values2)) {
                                          echo "selected";
                                        } ?>>Schwalbe</option>
                    <option value="226" <?php if (in_array('226', $values2)) {
                                          echo "selected";
                                        } ?>>Scudo</option>
                    <option value="227" <?php if (in_array('227', $values2)) {
                                          echo "selected";
                                        } ?>>Seatta</option>
                    <option value="228" <?php if (in_array('228', $values2)) {
                                          echo "selected";
                                        } ?>>Sebring</option>
                    <option value="229" <?php if (in_array('229', $values2)) {
                                          echo "selected";
                                        } ?>>Semperit</option>
                    <option value="230" <?php if (in_array('230', $values2)) {
                                          echo "selected";
                                        } ?>>Silver Stone</option>
                    <option value="231" <?php if (in_array('231', $values2)) {
                                          echo "selected";
                                        } ?>>Simex</option>
                    <option value="232" <?php if (in_array('232', $values2)) {
                                          echo "selected";
                                        } ?>>Solideal</option>
                    <option value="233" <?php if (in_array('233', $values2)) {
                                          echo "selected";
                                        } ?>>Solido</option>
                    <option value="234" <?php if (in_array('234', $values2)) {
                                          echo "selected";
                                        } ?>>Solimax</option>
                    <option value="235" <?php if (in_array('235', $values2)) {
                                          echo "selected";
                                        } ?>>Solitrac</option>
                    <option value="236" <?php if (in_array('236', $values2)) {
                                          echo "selected";
                                        } ?>>Solus</option>
                    <option value="237" <?php if (in_array('237', $values2)) {
                                          echo "selected";
                                        } ?>>Sonar</option>
                    <option value="238" <?php if (in_array('238', $values2)) {
                                          echo "selected";
                                        } ?>>Sonny</option>
                    <option value="239" <?php if (in_array('239', $values2)) {
                                          echo "selected";
                                        } ?>>Speedways</option>
                    <option value="240" <?php if (in_array('240', $values2)) {
                                          echo "selected";
                                        } ?>>Spider</option>
                    <option value="241" <?php if (in_array('241', $values2)) {
                                          echo "selected";
                                        } ?>>Sportiva</option>
                    <option value="242" <?php if (in_array('242', $values2)) {
                                          echo "selected";
                                        } ?>>Sportrak</option>
                    <option value="243" <?php if (in_array('243', $values2)) {
                                          echo "selected";
                                        } ?>>Starfire</option>
                    <option value="244" <?php if (in_array('244', $values2)) {
                                          echo "selected";
                                        } ?>>Starmaxx</option>
                    <option value="245" <?php if (in_array('245', $values2)) {
                                          echo "selected";
                                        } ?>>Strial</option>
                    <option value="246" <?php if (in_array('246', $values2)) {
                                          echo "selected";
                                        } ?>>Stunner</option>
                    <option value="247" <?php if (in_array('247', $values2)) {
                                          echo "selected";
                                        } ?>>Sumitomo</option>
                    <option value="248" <?php if (in_array('248', $values2)) {
                                          echo "selected";
                                        } ?>>Sumo</option>
                    <option value="249" <?php if (in_array('249', $values2)) {
                                          echo "selected";
                                        } ?>>Sunbear</option>
                    <option value="250" <?php if (in_array('250', $values2)) {
                                          echo "selected";
                                        } ?>>SunF</option>
                    <option value="251" <?php if (in_array('251', $values2)) {
                                          echo "selected";
                                        } ?>>Sunitrac</option>
                    <option value="252" <?php if (in_array('252', $values2)) {
                                          echo "selected";
                                        } ?>>Sunny</option>
                    <option value="253" <?php if (in_array('253', $values2)) {
                                          echo "selected";
                                        } ?>>Suntek</option>
                    <option value="254" <?php if (in_array('254', $values2)) {
                                          echo "selected";
                                        } ?>>Sunwide</option>
                    <option value="255" <?php if (in_array('255', $values2)) {
                                          echo "selected";
                                        } ?>>Superking</option>
                    <option value="256" <?php if (in_array('256', $values2)) {
                                          echo "selected";
                                        } ?>>Super Swamper</option>
                    <option value="257" <?php if (in_array('257', $values2)) {
                                          echo "selected";
                                        } ?>>Swallow</option>
                    <option value="258" <?php if (in_array('258', $values2)) {
                                          echo "selected";
                                        } ?>>Syron</option>
                    <option value="259" <?php if (in_array('259', $values2)) {
                                          echo "selected";
                                        } ?>>Talon</option>
                    <option value="260" <?php if (in_array('260', $values2)) {
                                          echo "selected";
                                        } ?>>Tatko</option>
                    <option value="261" <?php if (in_array('261', $values2)) {
                                          echo "selected";
                                        } ?>>Taurus</option>
                    <option value="262" <?php if (in_array('262', $values2)) {
                                          echo "selected";
                                        } ?>>TFT</option>
                    <option value="263" <?php if (in_array('263', $values2)) {
                                          echo "selected";
                                        } ?>>Three A</option>
                    <option value="264" <?php if (in_array('264', $values2)) {
                                          echo "selected";
                                        } ?>>Thunderer</option>
                    <option value="265" <?php if (in_array('265', $values2)) {
                                          echo "selected";
                                        } ?>>Tigar</option>
                    <option value="266" <?php if (in_array('266', $values2)) {
                                          echo "selected";
                                        } ?>>Tiron</option>
                    <option value="267" <?php if (in_array('267', $values2)) {
                                          echo "selected";
                                        } ?>>Tokai</option>
                    <option value="268" <?php if (in_array('268', $values2)) {
                                          echo "selected";
                                        } ?>>Toprunner</option>
                    <option value="269" <?php if (in_array('269', $values2)) {
                                          echo "selected";
                                        } ?>>Torque</option>
                    <option value="270" <?php if (in_array('270', $values2)) {
                                          echo "selected";
                                        } ?>>Touring</option>
                    <option value="271" <?php if (in_array('271', $values2)) {
                                          echo "selected";
                                        } ?>>Tovic</option>
                    <option value="272" <?php if (in_array('272', $values2)) {
                                          echo "selected";
                                        } ?>>Toyo</option>
                    <option value="273" <?php if (in_array('273', $values2)) {
                                          echo "selected";
                                        } ?>>Tracmax</option>
                    <option value="274" <?php if (in_array('274', $values2)) {
                                          echo "selected";
                                        } ?>>Transking</option>
                    <option value="275" <?php if (in_array('275', $values2)) {
                                          echo "selected";
                                        } ?>>Transporter</option>
                    <option value="276" <?php if (in_array('276', $values2)) {
                                          echo "selected";
                                        } ?>>Trayal</option>
                    <option value="277" <?php if (in_array('277', $values2)) {
                                          echo "selected";
                                        } ?>>Tri-Ace</option>
                    <option value="278" <?php if (in_array('278', $values2)) {
                                          echo "selected";
                                        } ?>>Triangle</option>
                    <option value="279" <?php if (in_array('279', $values2)) {
                                          echo "selected";
                                        } ?>>Tristar</option>
                    <option value="280" <?php if (in_array('280', $values2)) {
                                          echo "selected";
                                        } ?>>Tyrex</option>
                    <option value="281" <?php if (in_array('281', $values2)) {
                                          echo "selected";
                                        } ?>>Unilli</option>
                    <option value="282" <?php if (in_array('282', $values2)) {
                                          echo "selected";
                                        } ?>>Uniroyal</option>
                    <option value="283" <?php if (in_array('283', $values2)) {
                                          echo "selected";
                                        } ?>>Vee Rubber</option>
                    <option value="284" <?php if (in_array('284', $values2)) {
                                          echo "selected";
                                        } ?>>Victorun</option>
                    <option value="285" <?php if (in_array('285', $values2)) {
                                          echo "selected";
                                        } ?>>Viking</option>
                    <option value="286" <?php if (in_array('286', $values2)) {
                                          echo "selected";
                                        } ?>>Vitour</option>
                    <option value="287" <?php if (in_array('287', $values2)) {
                                          echo "selected";
                                        } ?>>Viva</option>
                    <option value="288" <?php if (in_array('288', $values2)) {
                                          echo "selected";
                                        } ?>>V-Netik</option>
                    <option value="289" <?php if (in_array('289', $values2)) {
                                          echo "selected";
                                        } ?>>Vredstein</option>
                    <option value="290" <?php if (in_array('290', $values2)) {
                                          echo "selected";
                                        } ?>>Wanli</option>
                    <option value="291" <?php if (in_array('291', $values2)) {
                                          echo "selected";
                                        } ?>>Waterfall</option>
                    <option value="292" <?php if (in_array('292', $values2)) {
                                          echo "selected";
                                        } ?>>Watts</option>
                    <option value="293" <?php if (in_array('293', $values2)) {
                                          echo "selected";
                                        } ?>>West Lake</option>
                    <option value="294" <?php if (in_array('294', $values2)) {
                                          echo "selected";
                                        } ?>>Windforce</option>
                    <option value="295" <?php if (in_array('295', $values2)) {
                                          echo "selected";
                                        } ?>>Winguard</option>
                    <option value="296" <?php if (in_array('296', $values2)) {
                                          echo "selected";
                                        } ?>>Winrun</option>
                    <option value="297" <?php if (in_array('297', $values2)) {
                                          echo "selected";
                                        } ?>>Woosung</option>
                    <option value="298" <?php if (in_array('298', $values2)) {
                                          echo "selected";
                                        } ?>>Wosen</option>
                    <option value="299" <?php if (in_array('299', $values2)) {
                                          echo "selected";
                                        } ?>>Yamaha</option>
                    <option value="300" <?php if (in_array('300', $values2)) {
                                          echo "selected";
                                        } ?>>Yatone</option>
                    <option value="301" <?php if (in_array('301', $values2)) {
                                          echo "selected";
                                        } ?>>Yokohama</option>
                    <option value="302" <?php if (in_array('302', $values2)) {
                                          echo "selected";
                                        } ?>>Yuanxing</option>
                    <option value="303" <?php if (in_array('303', $values2)) {
                                          echo "selected";
                                        } ?>>Zeetex</option>
                    <option value="304" <?php if (in_array('304', $values2)) {
                                          echo "selected";
                                        } ?>>Zestino</option>
                    <option value="305" <?php if (in_array('305', $values2)) {
                                          echo "selected";
                                        } ?>>Zeta</option>
                    <option value="306" <?php if (in_array('306', $values2)) {
                                          echo "selected";
                                        } ?>>Zetum</option>
                  <?php } if($grupid==2){ ?>
                    <option value="307" <?php if (in_array('307', $values2)) {
                                          echo "selected";
                                        } ?>>Bosch</option>
                    <option value="308" <?php if (in_array('308', $values2)) {
                                          echo "selected";
                                        } ?>>Makita</option>
                    <option value="309" <?php if (in_array('309', $values2)) {
                                          echo "selected";
                                        } ?>>Ceta Form</option>
                    <option value="310" <?php if (in_array('310', $values2)) {
                                          echo "selected";
                                        } ?>>S-Link</option>
                    <option value="311" <?php if (in_array('311', $values2)) {
                                          echo "selected";
                                        } ?>>Einhell</option>
                    <option value="312" <?php if (in_array('312', $values2)) {
                                          echo "selected";
                                        } ?>>Honda</option>
                    <option value="313" <?php if (in_array('313', $values2)) {
                                          echo "selected";
                                        } ?>>AEG</option>
                    <option value="314" <?php if (in_array('314', $values2)) {
                                          echo "selected";
                                        } ?>>Yamaha</option>
                    <option value="315" <?php if (in_array('315', $values2)) {
                                          echo "selected";
                                        } ?>>Ttec</option>
                    <option value="316" <?php if (in_array('316', $values2)) {
                                          echo "selected";
                                        } ?>>Powermaster</option>
                    <option value="317" <?php if (in_array('317', $values2)) {
                                          echo "selected";
                                        } ?>>Dewalt</option>
                    <option value="318" <?php if (in_array('318', $values2)) {
                                          echo "selected";
                                        } ?>>BMW</option>
                    <option value="319" <?php if (in_array('319', $values2)) {
                                          echo "selected";
                                        } ?>>Klpro</option>
                    <option value="320" <?php if (in_array('320', $values2)) {
                                          echo "selected";
                                        } ?>>Dremel</option>
                    <option value="321" <?php if (in_array('321', $values2)) {
                                          echo "selected";
                                        } ?>>3M</option>
                    <option value="322" <?php if (in_array('322', $values2)) {
                                          echo "selected";
                                        } ?>>Duracell</option>
                    <option value="323" <?php if (in_array('323', $values2)) {
                                          echo "selected";
                                        } ?>>RTRMAX</option>
                    <option value="324" <?php if (in_array('324', $values2)) {
                                          echo "selected";
                                        } ?>>Varta</option>
                    <option value="325" <?php if (in_array('325', $values2)) {
                                          echo "selected";
                                        } ?>>Safir</option>
                    <option value="326" <?php if (in_array('326', $values2)) {
                                          echo "selected";
                                        } ?>>Max Extra</option>
                    <option value="327" <?php if (in_array('327', $values2)) {
                                          echo "selected";
                                        } ?>>Hitachi</option>
                    <option value="328" <?php if (in_array('328', $values2)) {
                                          echo "selected";
                                        } ?>>Ryobi</option>
                    <option value="329" <?php if (in_array('329', $values2)) {
                                          echo "selected";
                                        } ?>>Yuasa</option>
                    <option value="330" <?php if (in_array('330', $values2)) {
                                          echo "selected";
                                        } ?>>Tunçmatik</option>
                    <option value="331" <?php if (in_array('331', $values2)) {
                                          echo "selected";
                                        } ?>>Mutlu</option>
                    <option value="332" <?php if (in_array('332', $values2)) {
                                          echo "selected";
                                        } ?>>Orbus</option>
                    <option value="333" <?php if (in_array('333', $values2)) {
                                          echo "selected";
                                        } ?>>Energy</option>
                    <option value="334" <?php if (in_array('334', $values2)) {
                                          echo "selected";
                                        } ?>>NOVA</option>
                    <option value="335" <?php if (in_array('335', $values2)) {
                                          echo "selected";
                                        } ?>>Makelsan</option>
                    <option value="336" <?php if (in_array('336', $values2)) {
                                          echo "selected";
                                        } ?>>Ataba</option>
                    <option value="337" <?php if (in_array('337', $values2)) {
                                          echo "selected";
                                        } ?>>Çelik</option>
                    <option value="338" <?php if (in_array('338', $values2)) {
                                          echo "selected";
                                        } ?>>Mervesan</option>
                    <option value="339" <?php if (in_array('339', $values2)) {
                                          echo "selected";
                                        } ?>>Inform</option>
                    <option value="340" <?php if (in_array('340', $values2)) {
                                          echo "selected";
                                        } ?>>Vlm Akü</option>
                    <option value="341" <?php if (in_array('341', $values2)) {
                                          echo "selected";
                                        } ?>>Atex</option>
                    <option value="342" <?php if (in_array('342', $values2)) {
                                          echo "selected";
                                        } ?>>Erbauer</option>
                    <option value="343" <?php if (in_array('343', $values2)) {
                                          echo "selected";
                                        } ?>>Ortec</option>
                    <option value="344" <?php if (in_array('344', $values2)) {
                                          echo "selected";
                                        } ?>>İnci</option>
                    <option value="345" <?php if (in_array('345', $values2)) {
                                          echo "selected";
                                        } ?>>Presiden</option>
                    <option value="346" <?php if (in_array('346', $values2)) {
                                          echo "selected";
                                        } ?>>Orion</option>
                    <option value="347" <?php if (in_array('347', $values2)) {
                                          echo "selected";
                                        } ?>>Volt</option>
                    <option value="348" <?php if (in_array('348', $values2)) {
                                          echo "selected";
                                        } ?>>Lexron</option>
                    <option value="349" <?php if (in_array('349', $values2)) {
                                          echo "selected";
                                        } ?>>Abg</option>
                    <option value="350" <?php if (in_array('350', $values2)) {
                                          echo "selected";
                                        } ?>>Hugel</option>
                    <option value="351" <?php if (in_array('351', $values2)) {
                                          echo "selected";
                                        } ?>>Yiğit</option>
                  <?php } ?>
                  <option value="352" <?php if (in_array('352', $values2)) {
                                        echo "selected";
                                      } ?>>Diğer</option>
                </select>
              </p>
            </div>
            <!--Tür seçme bölümü-->
            <br>
            <hr style="height:1px;border-width:0;color:gray;background-color:gray"> <br>
            <div class="form-group" style="background-color:#f5f5f5;padding:4%">
              <h6 style="display:inline">Türü Seçiniz</h6><br>
              <p style="padding-top:10px">
                <select class="selectpicker form-control" multiple data-live-search="true" name="alan[]">
                  <option value="none" selected="" disabled="">Türler</option>
                  <?php if ($grupid == 1 || $grupid == 0) { ?>
                    <option value="1" <?php if (in_array('1', $values3)) {
                                        echo "selected";
                                      } ?>>4x4, Pickup & SUV</option>
                    <option value="2" <?php if (in_array('2', $values3)) {
                                        echo "selected";
                                      } ?>>Minibüs & Kamyonet</option>
                    <option value="3" <?php if (in_array('3', $values3)) {
                                        echo "selected";
                                      } ?>>Otobüs, Kamyon & Çekici</option>
                    <option value="4" <?php if (in_array('4', $values3)) {
                                        echo "selected";
                                      } ?>>Zirai & Endüstriyel</option>
                    <option value="5" <?php if (in_array('5', $values3)) {
                                        echo "selected";
                                      } ?>>İş Makinesi</option>
                    <option value="6" <?php if (in_array('6', $values3)) {
                                        echo "selected";
                                      } ?>>Go-Kart</option>
                    <option value="7" <?php if (in_array('7', $values3)) {
                                        echo "selected";
                                      } ?>>Yarış</option>
                  <?php }
                  if ($grupid == 3 || $grupid == 0) { ?>
                    <option value="8" <?php if (in_array('8', $values3)) {
                                        echo "selected";
                                      } ?>> Otomobil/Arazi Aracı</option>
                    <option value="9" <?php if (in_array('9', $values3)) {
                                        echo "selected";
                                      } ?>> Kamyon&Kamyonet</option>
                    <option value="10" <?php if (in_array('10', $values3)) {
                                          echo "selected";
                                        } ?>>Otobüs&Minibüs</option>
                  <?php }
                  if ($grupid == 2 || $grupid == 0) { ?>
                    <option value="11" <?php if (in_array('11', $values3)) {
                                          echo "selected";
                                        } ?>>Kurşun-Asit Akü</option>
                    <option value="12" <?php if (in_array('12', $values3)) {
                                          echo "selected";
                                        } ?>>Sulu Akü</option>
                    <option value="13" <?php if (in_array('13', $values3)) {
                                          echo "selected";
                                        } ?>>Kuru Akü</option>
                    <option value="14" <?php if (in_array('14', $values3)) {
                                          echo "selected";
                                        } ?>>VRLA</option>
                    <option value="15" <?php if (in_array('15', $values3)) {
                                          echo "selected";
                                        } ?>>Derin döngü akü</option>
                    <option value="16" <?php if (in_array('16', $values3)) {
                                          echo "selected";
                                        } ?>>Lityum iyon akü</option>
                    <option value="17" <?php if (in_array('17', $values3)) {
                                          echo "selected";
                                        } ?>>AGM Akü</option>
                  <?php } ?>
                  <option value="18" <?php if (in_array('18', $values3)) {
                                        echo "selected";
                                      } ?>>Diğer</option>
                </select>
              </p>
            </div>
            <!--Durum seçme bölümü-->
            <br>
            <hr style="height:1px;border-width:0;color:gray;background-color:gray"> <br>
            <div style="background-color:#f5f5f5;padding:4%">
              <h6>Durumu seçiniz </h6>
              <div class="form-group">
                <label>
                  <input type="radio" name="radio" value="0" <?php if ($type_durum == 0) {
                                                                echo "checked";
                                                              } ?>>
                  <h6 style="display:inline">Sıfır</h6>
                </label> <br>
                <label>
                  <input type="radio" name="radio" value="1" <?php if ($type_durum == 1) {
                                                                echo "checked";
                                                              } ?>>
                  <h6 style="display:inline">İkinci el</h6>
                </label>
              </div>

            </div>



            <!--Ürun ebatı Seçme Bölümü-->
            <br>
            <hr style="height:1px;border-width:0;color:gray;background-color:gray"> <br>
            <div class="form-group" style="background-color:#f5f5f5;padding:4%">
              <h6 style="display:inline">Ürün ebatını Seçiniz</h6><br>
              <p style="padding-top:10px">
                <select class="selectpicker form-control" multiple data-live-search="true" name="yılı[]">
                  <option value="none" selected="" disabled="">Ebat</option>
                  <?php if ($grupid == 0 || $grupid == 3) { ?>
                    <option value="1" <?php if (in_array('1', $values4)) {
                                        echo "selected";
                                      } ?>>8 inç</option>
                    <option value="2" <?php if (in_array('2', $values4)) {
                                        echo "selected";
                                      } ?>>9 inç</option>
                    <option value="3" <?php if (in_array('3', $values4)) {
                                        echo "selected";
                                      } ?>>10 inç</option>
                    <option value="4" <?php if (in_array('4', $values4)) {
                                        echo "selected";
                                      } ?>>11 inç</option>
                    <option value="5" <?php if (in_array('5', $values4)) {
                                        echo "selected";
                                      } ?>>12 inç</option>
                    <option value="6" <?php if (in_array('6', $values4)) {
                                        echo "selected";
                                      } ?>>13 inç</option>
                    <option value="7" <?php if (in_array('7', $values4)) {
                                        echo "selected";
                                      } ?>>14 inç</option>
                    <option value="8" <?php if (in_array('8', $values4)) {
                                        echo "selected";
                                      } ?>>15 inç</option>
                    <option value="9" <?php if (in_array('9', $values4)) {
                                        echo "selected";
                                      } ?>>16 inç</option>
                    <option value="10" <?php if (in_array('10', $values4)) {
                                          echo "selected";
                                        } ?>>17 inç</option>
                    <option value="11" <?php if (in_array('11', $values4)) {
                                          echo "selected";
                                        } ?>>18 inç</option>
                    <option value="12" <?php if (in_array('12', $values4)) {
                                          echo "selected";
                                        } ?>>19 inç</option>
                    <option value="13" <?php if (in_array('13', $values4)) {
                                          echo "selected";
                                        } ?>>20 inç</option>
                    <option value="14" <?php if (in_array('14', $values4)) {
                                          echo "selected";
                                        } ?>>21 inç</option>
                    <option value="15" <?php if (in_array('15', $values4)) {
                                          echo "selected";
                                        } ?>>22 inç</option>
                    <option value="16" <?php if (in_array('16', $values4)) {
                                          echo "selected";
                                        } ?>>22.5 inç</option>
                    <option value="17" <?php if (in_array('17', $values4)) {
                                          echo "selected";
                                        } ?>>23 inç</option>
                    <option value="18" <?php if (in_array('18', $values4)) {
                                          echo "selected";
                                        } ?>>24 inç</option>
                    <option value="19" <?php if (in_array('19', $values4)) {
                                          echo "selected";
                                        } ?>>25 inç</option>
                    <option value="20" <?php if (in_array('20', $values4)) {
                                          echo "selected";
                                        } ?>>26 inç</option>
                  <?php  } ?>
                  <?php if ($grupid == 0 || $grupid == 1) { ?>
                    <option value="21" <?php if (in_array('21', $values4)) {
                                          echo "selected";
                                        } ?>>145-195 mm</option>
                    <option value="22" <?php if (in_array('22', $values4)) {
                                          echo "selected";
                                        } ?>>195-245 mm</option>
                    <option value="23" <?php if (in_array('23', $values4)) {
                                          echo "selected";
                                        } ?>>245-295 mm</option>
                    <option value="24" <?php if (in_array('24', $values4)) {
                                          echo "selected";
                                        } ?>>295-345 mm</option>
                    <option value="25" <?php if (in_array('25', $values4)) {
                                          echo "selected";
                                        } ?>>345++ mm</option>
                  <?php  } ?>
                  <option value="26" <?php if (in_array('26', $values4)) {
                                        echo "selected";
                                      } ?>>Diğer</option>
                </select>
              </p>
            </div>
            <br>
            <hr style="height:1px;border-width:0;color:gray;background-color:gray"> <br>
            <div style="background-color:#f5f5f5;padding:4%">
              <h5>Tarihi seçiniz</h5>
              <div class="form-group">
                <label>
                  <input type="radio" name="radio1" value="1" <?php if ($type_day == 1) {
                                                                echo "checked";
                                                              } ?>>
                  <h6 style="display:inline">Son 1 gün içinde</h6>
                </label> <br>
                <label>
                  <input type="radio" name="radio1" value="3" <?php if ($type_day == 3) {
                                                                echo "checked";
                                                              } ?>>
                  <h6 style="display:inline">Son 3 gün içinde</h6>
                </label> <br>
                <label>
                  <input type="radio" name="radio1" value="7" <?php if ($type_day == 7) {
                                                                echo "checked";
                                                              } ?>>
                  <h6 style="display:inline">Son 7 gün içinde</h6>
                </label> <br>
                <label>
                  <input type="radio" name="radio1" value="15" <?php if ($type_day == 15) {
                                                                  echo "checked";
                                                                } ?>>
                  <h6 style="display:inline">Son 15 gün içinde</h6>
                </label> <br>
                <label>
                  <input type="radio" name="radio1" value="30" <?php if ($type_day == 30) {
                                                                  echo "checked";
                                                                } ?>>
                  <h6 style="display:inline">Son 30 gün içinde</h6>
                </label>
              </div>
            </div>
            <br>
            <div style="text-align:center;padding-top:3%">
              <button class="button" name="ara" style="background-color:#908f8f;width:70%;height:7%;font-size:1.5rem">Ara</button>
            </div>
          </form>
        </div>
        <div class="col-8">
          <?php
          $sql_sorgusu = $sql_sorgusu . $state . $sehir . $tarih . $yılı . $marka . $alan . $price;
          $door = true;
          $res = mysqli_query($conn, $sql_sorgusu);
          $sayac = 0;
          ?>

          <?php
          while ($row = mysqli_fetch_array($res)) {
            $door = false;
            $sayac++;
            if ($sayac == 1) {
          ?>

              <table class="table" cellpadding="10">
                <thead class="thead" style="background-color:#363636;color:white;">
                  <tr>
                    <th>İmage</th>
                    <th>İlan başlığı</th>
                    <th>İlan fiyatı</th>
                    <th>İlan tarihi</th>
                    <th>Ürün markası</th>
                    <th>Ürün kullanım alanı</th>
                    <th>il</th>
                  </tr>
                </thead>
                <tbody>
                <?php } ?>
                <tr style="height:7rem">
                  <th class="ellipsis first" scope="row" style="height:100%;background-color:#f8f8ff;border:2px solid white"> <a href="product.php?ProductID=<?php echo $row['id']; ?>" style="text-decoration : none;color:black"> <img src="data:image/jpeg;base64,<?php echo base64_encode($row['image']); ?>" style="height:8rem" /> </a> </th>
                  <td class="ellipsis" style="background-color:#f8f8ff;border:2px solid white;"> <a href="product.php?grup_id=<?php echo $grupid; ?>&&ProductID=<?php echo $row['id']; ?>" style="text-decoration : none ;color:black"> <br>
                      <p> <?php echo $row['head_name']; ?></p>
                    </a> </td>
                  <td class="ellipsis" style="background-color:#f8f8ff;border:2px solid white;"> <a href="product.php?grup_id=<?php echo $grupid; ?>&&ProductID=<?php echo $row['id']; ?>" style="text-decoration : none ;color:black"> <br>
                      <p> <?php echo $row['price']; ?>₺</p>
                    </a> </td>
                  <td class="ellipsis" style="background-color:#f8f8ff;border:2px solid white;"> <a href="product.php?grup_id=<?php echo $grupid; ?>&&ProductID=<?php echo $row['id']; ?>" style="text-decoration : none; color:black"> <br>
                      <p> <?php echo $row['create_date']; ?>
                    </a> </h6>
                  </td>
                  <td class="ellipsis" style="background-color:#f8f8ff;border:2px solid white;"> <a href="product.php?grup_id=<?php echo $grupid; ?>&&ProductID=<?php echo $row['id']; ?>" style="text-decoration : none ; color:black"> <br>
                      <p> <?php $adword_marka = $row['adword_marka'];
                          if ($adword_marka == 1) {
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
                      </p>
                    </a> </td>
                  <td class="ellipsis" style="background-color:#f8f8ff;border:2px solid white;"> <a href="product.php?grup_id=<?php echo $grupid; ?>&&ProductID=<?php echo $row['id']; ?>" style="text-decoration : none ; color:black"> <br>
                      <p> <?php $adword_alan = $row['adword_kullanım_yeri'];
                          if ($adword_alan == 1) {
                            echo "4x4, Pickup & SUV";
                          } else if ($adword_alan == 2) {
                            echo "Minibüs & Kamyonet";
                          } else if ($adword_alan == 3) {
                            echo "Otobüs, Kamyon & Çekici";
                          } else if ($adword_alan == 4) {
                            echo "Zirai & Endüstriyel";
                          } else if ($adword_alan == 5) {
                            echo "İş Makinesi";
                          } else if ($adword_alan == 6) {
                            echo "Go-Kart";
                          } else if ($adword_alan == 7) {
                            echo "Yarış";
                          } else if ($adword_alan == 8) {
                            echo "Otomobil/Arazi Aracı";
                          } else if ($adword_alan == 9) {
                            echo "Kamyon&Kamyonet";
                          } else if ($adword_alan == 10) {
                            echo "Otobüs&Minibüs";
                          } else if ($adword_alan == 11) {
                            echo "Kurşun-Asit Akü";
                          } else if ($adword_alan == 12) {
                            echo "Sulu Akü";
                          } else if ($adword_alan == 13) {
                            echo "kuru Akü";
                          } else if ($adword_alan == 14) {
                            echo "VRLA";
                          } else if ($adword_alan == 15) {
                            echo "Derin Döngü Akü";
                          } else if ($adword_alan == 16) {
                            echo "Lityom İyon Akü";
                          } else if ($adword_alan == 17) {
                            echo "AGM Akü";
                          } else {
                            echo "Diğer";
                          }
                          ?> </p>
                    </a> </td>
                  <td class="ellipsis" style="background-color:#f8f8ff;border:2px solid white;"> <a href="product.php?grup_id=<?php echo $grupid; ?>&&ProductID=<?php echo $row['id']; ?>" style="text-decoration : none ; color:black"> <br>
                      <p> <?php echo $row['city']; ?> </p>
                    </a> </td>
                </tr>
              <?php } ?>
                </tbody>
              </table>
              <?php if ($door) { ?>
                <div style="text-align: center;">
                  <hr style="height: 40%">
                  <h3>
                    Aradığınız kriterlere uygun bir ürün bulunamamıştır.
                  </h3>
                </div>
              <?php } ?>
        </div>
      </div>
    </div>
    </div>
  </main><!-- End #main -->

  <?php include "footer.php"; ?>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
  <!-- for multiselect -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

</body>

</html>