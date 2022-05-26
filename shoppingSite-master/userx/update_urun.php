<?php
include "db.php";
include "header.php";
$conn = OpenCon();
error_reporting(0);
?>
<?php
session_start();
$user_id = $_SESSION["user_id"];
$urun_id = $_GET['urun_id'];
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
$urun = mysqli_query($conn, "SELECT * FROM adword_list WHERE id = $urun_id");
while ($row2 = mysqli_fetch_array($urun)) {

    $urun_name = $row2['head_name'];
    $fiyat = $row2['price'];
    $image = base64_encode($row2['image']);
    $cat_list_id = $row2['category_list_id'];
    $state = $row2['adword_state'];
    $marka = $row2['adword_marka'];
    $yıl = $row2['adword_ebat'];
    $alan = $row2['adword_kullanım_yeri'];
    $detail = $row2['adword_detail'];
    $meta = $row2['meta'];
}
$arr_image_id = [];
for ($if = 0; $if < 9; $if++) {
    $arr_image_id[$if] = 0;
}
$ikl = 0;
$ur = mysqli_query($conn, "SELECT id,name FROM adword_image_list WHERE adword_list_id = $urun_id");
while ($rowl = mysqli_fetch_array($ur)) {
    $deper = $rowl['id'];
    $arr_image_id[$ikl] = $deper;
    $ikl++;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {

    $val1 = $_POST['head_name'];
    $val2 = $_POST['product_group'];
    $val3 = $_POST['price'];
    $val4 = $_POST['meta'];
    $val5 = $_POST['product_state'];
    $val6 = $_POST['product_marka'];
    $val7 = $_POST['product_year'];
    $val8 = $_POST['product_used'];
    $val9 = $_POST['urun_detay'];
    if ($val7 == null) {
        $val7 = 50;
    }
    for ($if = 0; $if < 9; $if++) {

        $images = $_FILES['image' . $if]['tmp_name'];

        if ($images != null) {

            if ($arr_image_id[$if] != 0) {
                $file1 = addslashes(file_get_contents($_FILES['image' . $if]['tmp_name']));
                $door = mysqli_query($conn, "UPDATE adword_image_list SET image = '$file1' WHERE id =  $arr_image_id[$if] ");

                //continue;
            } else {
                //ekleme yapıcak
                $img = file_get_contents($images);
                $sql = "INSERT INTO adword_image_list (adword_list_id,user_id,image) values( $urun_id , $user_id ,?)";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "s", $img);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_affected_rows($stmt);
                //  continue;
                // print_r(error_get_last());
            }
        }
    }
    // print_r($arr_image_id);       
    $file = $_FILES['file']['tmp_name'];

    if ($file != null) {

        $file = addslashes(file_get_contents($_FILES['file']['tmp_name']));
        //bu alanda image li update lazım tek ana resim için adword_image de 
        $sql = "UPDATE adword_list SET image = '$file' , adword_marka = $val6 , adword_ebat = $val7 , adword_kullanım_yeri = $val8 , adword_detail = '$val9' ,  adword_state = $val5 , head_name = '$val1' , category_list_id = $val2 , price = $val3 , meta = '$val4' WHERE id = $urun_id";
        $gh = mysqli_query($conn, $sql);
        if ($gh) {
            echo '<script language="javascript">';
            echo 'alert("İlan güncellenmiştir")';  //not showing an alert box.
            echo '</script>';
        } else {
            echo '<script language="javascript">';
            echo 'alert("Güncelleme başarısız")';  //not showing an alert box.
            echo '</script>';
        }
    } else {
        //burada ana resim eklenmediği için direkt update
        $sql = "UPDATE adword_list SET adword_marka = $val6 ,adword_ebat = $val7, adword_kullanım_yeri = $val8 , adword_detail = " . "'$val9'" . " ,  adword_state = " . "'$val5'" . " , head_name = " . "'$val1'" . " , category_list_id = $val2 , price = $val3 , meta =  " . "'$val4'" . " WHERE id = $urun_id";
        $check = mysqli_query($conn, $sql);
        if ($check) {
            echo '<script language="javascript">';
            echo 'alert("İlan güncellenmiştir")';  //not showing an alert box.
            echo '</script>';
        } else {
            echo '<script language="javascript">';
            echo 'alert("Güncelleme  başarısız.")';  //not showing an alert box.
            echo '</script>';
        }
    }
    header("Refresh:0");
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" href="style.css">
    <!-- Boxicons CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:700|Raleway:500.700" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <section class="home-section">
        <div id="content">
            <form action="" method="POST" enctype="multipart/form-data">
                <fieldset>
                    <div>
                        <div style="padding-left:35%;color:#6d7fcc">
                            <h3 class="title"><u>İlanı düzenle</u></h3>
                            <br>
                        </div>
                        <div class="container">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>Ürün Adı</label>
                                        <input type="text" class="form-control" name="head_name" value="<?php echo $urun_name; ?>">
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>Ürün Grubu</label>
                                        <select name="product_group" class="form-control" id="grup" onchange="run()">
                                            <option <?php if ($cat_list_id == 2) {
                                                        echo "selected";
                                                    } ?> value="<?php echo 2; ?>">Akü</option>
                                            <option <?php if ($cat_list_id == 3) {
                                                        echo "selected";
                                                    } ?> value="<?php echo 3; ?>">Jant</option>
                                            <option <?php if ($cat_list_id == 1) {
                                                        echo "selected";
                                                    } ?> value="<?php echo 1; ?>">Lastik</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>Ürün markası</label>
                                        <select name="product_marka" class="form-control" id="marka">
                                            <option value="none" disabled="">Markalar</option>
                                            <?php if ($cat_list_id != 2) { ?>
                                                <option value="1" <?php if ($marka == 1) {
                                                                        echo "selected";
                                                                    } ?>>Michelin</option>
                                                <option value="2" <?php if ($marka == 2) {
                                                                        echo "selected";
                                                                    } ?>>Bridgestone</option>
                                                <option value="3" <?php if ($marka == 3) {
                                                                        echo "selected";
                                                                    } ?>>Goodyear</option>
                                                <option value="4" <?php if ($marka == 4) {
                                                                        echo "selected";
                                                                    } ?>>Continental</option>
                                                <option value="5" <?php if ($marka == 5) {
                                                                        echo "selected";
                                                                    } ?>>Lassa</option>
                                                <option value="6" <?php if ($marka == 6) {
                                                                        echo "selected";
                                                                    } ?>>Petlas</option>
                                                <option value="7" <?php if ($marka == 7) {
                                                                        echo "selected";
                                                                    } ?>>Pirelli</option>
                                                <option value="8" <?php if ($marka == 8) {
                                                                        echo "selected";
                                                                    } ?>>Hankook</option>
                                                <option value="9" <?php if ($marka == 9) {
                                                                        echo "selected";
                                                                    } ?>>Kormoran</option>
                                                <option value="10" <?php if ($marka == 10) {
                                                                        echo "selected";
                                                                    } ?>>Taurus</option>
                                                <option value="11" <?php if ($marka == 11) {
                                                                        echo "selected";
                                                                    } ?>>Kumho</option>
                                                <option value="12" <?php if ($marka == 12) {
                                                                        echo "selected";
                                                                    } ?>>Marshal</option>
                                                <option value="13" <?php if ($marka == 13) {
                                                                        echo "selected";
                                                                    } ?>>Riken</option>
                                                <option value="14" <?php if ($marka == 14) {
                                                                        echo "selected";
                                                                    } ?>>Dunlop</option>
                                                <option value="15" <?php if ($marka == 15) {
                                                                        echo "selected";
                                                                    } ?>>Sava</option>
                                                <option value="16" <?php if ($marka == 16) {
                                                                        echo "selected";
                                                                    } ?>>Debica</option>
                                                <option value="17" <?php if ($marka == 17) {
                                                                        echo "selected";
                                                                    } ?>>Bf</option>
                                                <option value="18" <?php if ($marka == 18) {
                                                                        echo "selected";
                                                                    } ?>>Vossen</option>
                                                <option value="19" <?php if ($marka == 19) {
                                                                        echo "selected";
                                                                    } ?>>Gram Lights</option>
                                                <option value="20" <?php if ($marka == 20) {
                                                                        echo "selected";
                                                                    } ?>>Konig</option>
                                                <option value="21" <?php if ($marka == 21) {
                                                                        echo "selected";
                                                                    } ?>>Volk</option>
                                                <option value="22" <?php if ($marka == 22) {
                                                                        echo "selected";
                                                                    } ?>>O.Z.</option>
                                                <option value="23" <?php if ($marka == 23) {
                                                                        echo "selected";
                                                                    } ?>>Enkei</option>
                                                <option value="24" <?php if ($marka == 24) {
                                                                        echo "selected";
                                                                    } ?>>Ronal</option>
                                                <option value="25" <?php if ($marka == 25) {
                                                                        echo "selected";
                                                                    } ?>>BBS</option>
                                            <?php } else { ?>
                                                <option value="26" <?php if ($marka == 26) {
                                                                        echo "selected";
                                                                    } ?>>Varta</option>
                                                <option value="27" <?php if ($marka == 27) {
                                                                        echo "selected";
                                                                    } ?>>Mutlu Akü</option>
                                                <option value="28" <?php if ($marka == 28) {
                                                                        echo "selected";
                                                                    } ?>>İnci Akü</option>
                                                <option value="29" <?php if ($marka == 29) {
                                                                        echo "selected";
                                                                    } ?>>Bosch</option>
                                                <option value="30" <?php if ($marka == 30) {
                                                                        echo "selected";
                                                                    } ?>>Yiğit Akü</option>
                                                <option value="31" <?php if ($marka == 31) {
                                                                        echo "selected";
                                                                    } ?>>President</option>
                                                <option value="32" <?php if ($marka == 32) {
                                                                        echo "selected";
                                                                    } ?>>Hugel</option>
                                                <option value="33" <?php if ($marka == 33) {
                                                                        echo "selected";
                                                                    } ?>>Powermaster Modified Sinus İnverter Kuru Akü</option>
                                                <option value="34" <?php if ($marka == 34) {
                                                                        echo "selected";
                                                                    } ?>>Delphi</option>
                                                <option value="35" <?php if ($marka == 35) {
                                                                        echo "selected";
                                                                    } ?>>Dayton</option>
                                                <option value="36" <?php if ($marka == 36) {
                                                                        echo "selected";
                                                                    } ?>>Exide</option>
                                            <?php }  ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>Ürün kullanım yeri</label>
                                        <select name="product_used" class="form-control" name="alan" id="tür">
                                            <option value="none" disabled="">Türler</option>
                                            <?php if ($cat_list_id == 1) { ?>
                                                <option value="1" <?php if ($alan == 1) {
                                                                        echo "selected";
                                                                    } ?>>4x4, Pickup & SUV</option>
                                                <option value="2" <?php if ($alan == 2) {
                                                                        echo "selected";
                                                                    } ?>>Minibüs & Kamyonet</option>
                                                <option value="3" <?php if ($alan == 3) {
                                                                        echo "selected";
                                                                    } ?>>Otobüs, Kamyon & Çekici</option>
                                                <option value="4" <?php if ($alan == 4) {
                                                                        echo "selected";
                                                                    } ?>>Zirai & Endüstriyel</option>
                                                <option value="5" <?php if ($alan == 5) {
                                                                        echo "selected";
                                                                    } ?>>İş Makinesi</option>
                                                <option value="6" <?php if ($alan == 6) {
                                                                        echo "selected";
                                                                    } ?>>Go-Kart</option>
                                                <option value="7" <?php if ($alan == 7) {
                                                                        echo "selected";
                                                                    } ?>>Yarış</option>
                                            <?php } else if ($cat_list_id == 3) { ?>
                                                <option value="8" <?php if ($alan == 8) {
                                                                        echo "selected";
                                                                    } ?>> İç Lastiksiz Jant</option>
                                                <option value="9" <?php if ($alan == 9) {
                                                                        echo "selected";
                                                                    } ?>> İç Lastikli Jant</option>
                                                <option value="10" <?php if ($alan == 10) {
                                                                        echo "selected";
                                                                    } ?>>Göbeksiz Jant</option>
                                                <option value="11" <?php if ($alan == 11) {
                                                                        echo "selected";
                                                                    } ?>>Alüminyum Alaşımlı Jantlar</option>
                                                <option value="12" <?php if ($alan == 12) {
                                                                        echo "selected";
                                                                    } ?>>Magnezyum Alaşımlı Jantlar</option>
                                                <option value="13" <?php if ($alan == 13) {
                                                                        echo "selected";
                                                                    } ?>>Sac Jantlar</option>
                                            <?php } else { ?>
                                                <option value="14" <?php if ($alan == 14) {
                                                                        echo "selected";
                                                                    } ?>>Kurşun-Asit Akü</option>
                                                <option value="15" <?php if ($alan == 15) {
                                                                        echo "selected";
                                                                    } ?>>Sulu Akü</option>
                                                <option value="16" <?php if ($alan == 16) {
                                                                        echo "selected";
                                                                    } ?>>Kuru Akü</option>
                                                <option value="17" <?php if ($alan == 17) {
                                                                        echo "selected";
                                                                    } ?>>VRLA</option>
                                                <option value="18" <?php if ($alan == 18) {
                                                                        echo "selected";
                                                                    } ?>>Derin döngü akü</option>
                                                <option value="19" <?php if ($alan == 19) {
                                                                        echo "selected";
                                                                    } ?>>Lityum iyon akü</option>
                                                <option value="20" <?php if ($alan == 20) {
                                                                        echo "selected";
                                                                    } ?>>AGM Akü</option>
                                            <?php }  ?>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-5"><br> <br>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Fiyatı</label>
                                        <input type="text" class="form-control" name="price" placeholder="ör: 17.99" value="<?php echo $fiyat; ?>">
                                    </div> <br> <br>
                                    <div class="form-group">
                                        <label>Ürünün durumu</label>
                                        <select name="product_state" class="form-control">
                                            <option value="none" disabled="">Durumu</option>
                                            <option <?php if ($state == 0) {
                                                        echo "selected";
                                                    } ?> value="0">Sıfır</option>
                                            <option <?php if ($state == 1) {
                                                        echo "selected";
                                                    } ?> value="1">İkinci el</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <br>
                                    <div class="form-group">
                                        <img src="data:image/jpeg;base64,<?php echo $image; ?>" alt="Avatar" style="max-height:200px;max-width:200px">
                                    </div>
                                </div><!-- row -->

                                <div class="col-md-2" style="margin-top: 7%;">
                                    <br>
                                    <div class="form-group">
                                        <label>Yeni resim ekle</label>
                                        <input type="file" name="file">
                                    </div>
                                </div>

                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>Ürün Ebatı</label>
                                        <select name="product_year" class="form-control" id="yıl">
                                            <option value="0" disabled="">Ebat</option>
                                            <?php if ($cat_list_id == 3) { ?>
                                                <option value="1" <?php if ($yıl == 1) {
                                                                        echo "selected";
                                                                    } ?>>12 inç</option>
                                                <option value="2" <?php if ($yıl == 2) {
                                                                        echo "selected";
                                                                    } ?>>13 inç</option>
                                                <option value="3" <?php if ($yıl == 3) {
                                                                        echo "selected";
                                                                    } ?>>14 inç</option>
                                                <option value="4" <?php if ($yıl == 4) {
                                                                        echo "selected";
                                                                    } ?>>15 inç</option>
                                                <option value="5" <?php if ($yıl == 5) {
                                                                        echo "selected";
                                                                    } ?>>16 inç</option>
                                                <option value="6" <?php if ($yıl == 6) {
                                                                        echo "selected";
                                                                    } ?>>17 inç</option>
                                                <option value="7" <?php if ($yıl == 7) {
                                                                        echo "selected";
                                                                    } ?>>18 inç</option>
                                                <option value="8" <?php if ($yıl == 8) {
                                                                        echo "selected";
                                                                    } ?>>19 inç</option>
                                                <option value="9" <?php if ($yıl == 9) {
                                                                        echo "selected";
                                                                    } ?>>20+ inç</option>
                                            <?php } else if ($cat_list_id == 1) { ?>
                                                <option value="10" <?php if ($yıl == 10) {
                                                                        echo "selected";
                                                                    } ?>>145-195 mm</option>
                                                <option value="11" <?php if ($yıl == 11) {
                                                                        echo "selected";
                                                                    } ?>>195-245 mm</option>
                                                <option value="12" <?php if ($yıl == 12) {
                                                                        echo "selected";
                                                                    } ?>>245-295 mm</option>
                                                <option value="13" <?php if ($yıl == 13) {
                                                                        echo "selected";
                                                                    } ?>>295-345 mm</option>
                                                <option value="14" <?php if ($yıl == 14) {
                                                                        echo "selected";
                                                                    } ?>>345++ mm</option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label>Google Arama Anahtar Kelimeler</label>
                                        <input type="text" value="<?php echo $meta; ?>" class="form-control" name="meta" placeholder="Lütfen virgül kullanarak, max 15 anahtar kelime giriniz.">
                                    </div>

                                </div>

                                <br> <br>

                                <div class="col-md-10">
                                    <div class="form-group">
                                        <ul class="nav nav-tabs">
                                            <li><a href="#aaa" data-toggle="tab">Ürün için daha fazla resim ekle</a></li>
                                        </ul>
                                        <div class="tab-content" id="tabs">
                                            <div class="tab-pane" id="aaa">
                                                <div class="container" style="padding-top:3%">
                                                    <div class="row">
                                                        <?php $ikl = 0;
                                                        $getk = mysqli_query($conn, "SELECT * FROM adword_image_list WHERE  adword_list_id = $urun_id");
                                                        while ($row2 = mysqli_fetch_array($getk)) {
                                                        ?>
                                                            <div class="form-group col-md-5">
                                                                <div class="row">
                                                                    <div class="form-group col-md-6">
                                                                        <p style="font-size:small;">Yandaki resmi değiştir</p>
                                                                        <input type="file" class="form-control" style="display: inline;" id="customFile" name="image<?php echo $ikl; ?>" />
                                                                    </div>
                                                                    <div class="form-group col-md-4">

                                                                        <img src="data:image/jpeg;base64,<?php echo  base64_encode($row2['image']); ?>" style="max-height:80px;max-width:100px" />

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php $ikl++;
                                                        } ?>
                                                        <?php for ($ikl; $ikl < 9; $ikl++) { ?>
                                                            <div class="form-group col-md-5">
                                                                <div class="row">
                                                                    <div class="form-group col-md-5">
                                                                        <input type="file" class="form-control" id="customFile" name="image<?php echo $ikl; ?>" />
                                                                    </div>
                                                                    <div class="form-group col-md-5">

                                                                        Mevcut bir resim yok
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label>Ürün Açıklaması</label>
                                        <textarea rows="6" class="form-control" name="urun_detay"><?php echo $detail; ?></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label"></label>
                                    <div class="col-md-4"><br>
                                        <input type="submit" class="btn" style="background-color: #7386D5;width:60%;color:white" name="update">
                                    </div>
                                </div>


                            </div>
                        </div>



                    </div>
                </fieldset>
            </form>
            <script>
                const ebat = [
                    "12 inç",
                    "13 inç",
                    "14 inç",
                    "15 inç",
                    "16 inç",
                    "17 inç",
                    "18 inç",
                    "19 inç",
                    "20+ inç",
                    "145-195 mm",
                    "195-245 mm",
                    "245-295 mm",
                    "295-345 mm",
                    "345++ mm"
                ]
                const tür = [
                    "4x4, Pickup & SUV",
                    "Minibüs & Kamyonet",
                    "Otobüs, Kamyon & Çekici",
                    "Zirai & Endüstriyel",
                    "İş Makinesi",
                    "Go-Kart",
                    "Yarış",
                    "İç Lastiksiz Jant",
                    "İç Lastikli Jant",
                    "Göbeksiz Jant",
                    "Alüminyum Alaşımlı Jantlar",
                    "Magnezyum Alaşımlı Jantlar",
                    "Sac Jantlar",
                    "Kurşun-Asit Akü",
                    "Sulu Akü",
                    "Kuru Akü",
                    "VRLA",
                    "Derin döngü akü",
                    "Lityum iyon akü",
                    "AGM Akü",
                ]
                const marka = [
                    "Michelin",
                    "Bridgestone",
                    "Goodyear",
                    "Continental",
                    "Lassa",
                    "Petlas",
                    "Pirelli",
                    "Hankook",
                    "Kormoran",
                    "Taurus",
                    "Kumho",
                    "Marshal",
                    "Riken",
                    "Dunlop",
                    "Sava",
                    "Debica",
                    "Bf",
                    "Vossen",
                    "Gram Lights",
                    "Konig",
                    "Volk",
                    "O.Z.",
                    "Enkei",
                    "Ronal",
                    "BBS",
                    "Varta",
                    "Mutlu Akü",
                    "İnci Akü",
                    "Bosch",
                    "Yiğit Akü",
                    "President",
                    "Hugel",
                    "Powermaster Modified Sinus İnverter Kuru Akü",
                    "Delphi",
                    "Dayton",
                    "Exide"
                ]

                function run() {
                    var e = document.getElementById("grup");
                    var strUser = e.options[e.selectedIndex].text;
                    if (strUser == "Jant") {
                        //öncekileri silme
                        var select2 = document.getElementById("yıl");
                        var length = select2.options.length;
                        for (i = length - 1; i > 0; i--) {
                            select2.options[i] = null;
                        }
                        //sonra yenileri ekliyor ürün ebatını
                        var select = document.getElementById('yıl');
                        for (var i = 0; i < 9; i++) {
                            option = document.createElement('option');
                            option.value = i + 1;
                            option.text = ebat[i];
                            select.add(option);
                        }

                        //aynı şekilde tür için silme yapıyor
                        var select3 = document.getElementById("tür");
                        var length = select3.options.length;
                        for (i = length - 1; i > 0; i--) {
                            select3.options[i] = null;
                        }
                        //sonra yenileri ekliyor ürün türünü
                        var select4 = document.getElementById('tür');
                        for (var i = 7; i < 13; i++) {
                            option = document.createElement('option');
                            option.value = i + 1;
                            option.text = tür[i];
                            select4.add(option);
                        }
                    } else if (strUser == "Lastik") {
                        var select2 = document.getElementById("yıl");
                        var length = select2.options.length;
                        for (i = length - 1; i > 0; i--) {
                            select2.options[i] = null;
                        }
                        var select1 = document.getElementById('yıl');
                        for (var i = 9; i < 14; i++) {
                            option = document.createElement('option');
                            option.value = i + 1;
                            option.text = ebat[i];
                            select1.add(option);
                        }

                        //aynı şekilde tür için silme yapıyor
                        var select3 = document.getElementById("tür");
                        var length = select3.options.length;
                        for (i = length - 1; i > 0; i--) {
                            select3.options[i] = null;
                        }
                        //sonra yenileri ekliyor ürün türünü
                        var select4 = document.getElementById('tür');
                        for (var i = 0; i < 7; i++) {
                            option = document.createElement('option');
                            option.value = i + 1;
                            option.text = tür[i];
                            select4.add(option);
                        }
                    } else {
                        var select2 = document.getElementById("yıl");
                        var length = select2.options.length;
                        for (i = length - 1; i > 0; i--) {
                            select2.options[i] = null;
                        }

                        //aynı şekilde tür için silme yapıyor
                        var select3 = document.getElementById("tür");
                        var length = select3.options.length;
                        for (i = length - 1; i > 0; i--) {
                            select3.options[i] = null;
                        }
                        //sonra yenileri ekliyor ürün türünü
                        var select4 = document.getElementById('tür');
                        for (var i = 13; i < 20; i++) {
                            option = document.createElement('option');
                            option.value = i + 1;
                            option.text = tür[i];
                            select4.add(option);
                        }

                        //aynı şekilde marka için silme yapıyor
                        var select5 = document.getElementById("marka");
                        var length = select5.options.length;
                        for (i = length - 1; i > 0; i--) {
                            select5.options[i] = null;
                        }
                        //sonra yenileri ekliyor ürün marka
                        var select6 = document.getElementById('marka');
                        for (var i = 25; i < 36; i++) {
                            option = document.createElement('option');
                            option.value = i + 1;
                            option.text = marka[i];
                            select6.add(option);
                        }
                    }
                    if (strUser != "Akü") {
                        //aynı şekilde marka için silme yapıyor
                        var select3 = document.getElementById("marka");
                        var length = select3.options.length;
                        for (i = length - 1; i > 0; i--) {
                            select3.options[i] = null;
                        }
                        //sonra yenileri ekliyor ürün marka
                        var select4 = document.getElementById('marka');
                        for (var i = 0; i < 25; i++) {
                            option = document.createElement('option');
                            option.value = i + 1;
                            option.text = marka[i];
                            select4.add(option);
                        }
                    }
                }
            </script>
        </div>
    </section>
    <script src="script.js"></script>
</body>

</html>