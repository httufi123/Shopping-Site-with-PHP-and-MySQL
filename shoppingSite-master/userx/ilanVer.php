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

if (isset($_POST['add']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $urun_name = $_POST['head_name'];
    $fiyat = $_POST['price'];
    $meta = $_POST['meta'];
    $detay = $_POST['detay'];
    $urun_category = $_POST['product_group'];
    $urun_year = $_POST['product_year'];
    $urun_used = $_POST['product_used'];
    $urun_marka = $_POST['product_marka'];
    $urun_durumu = $_POST['product_state'];
    if ($urun_year == null) {
        $urun_year = 50;
    }
    $door = false;
    //ana resmi yüklüyoz  
    $image = $_FILES['image']['tmp_name'];

    $img = file_get_contents($image);
    $sql = "INSERT INTO check_adword_list (city,adword_detail,meta,user_id,head_name,category_list_id,price,adword_state,adword_marka,adword_ebat,adword_kullanım_yeri,image) values(" . "'$city'" . "," . "'$detay'" . "," . "'$meta'" . "," . "'$user_id'" . "," . "'$urun_name'" . "," . "'$urun_category'" . "," . "'$fiyat'" . "," . "'$urun_durumu'" . "," . "'$urun_marka'" . "," . "'$urun_year'" . "," . "'$urun_used'" . ",?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $img);
    mysqli_stmt_execute($stmt);
    $check = mysqli_stmt_affected_rows($stmt);
    if ($check == 1) {
        $door = true;
        $last_id = $conn->insert_id;
        for ($i = 1; $i < 10; $i++) {
            $image = $_FILES['image' . $i]['tmp_name'];
            if ($image != null) {
                $img = file_get_contents($image);
                $sql = "INSERT INTO check_adword_image_list  (check_adword_list_id,user_id,name,image) values(" . "'$last_id'" . "," . "'$user_id'" . "," . "'$urun_name'" . ",?)";

                $stmt = mysqli_prepare($conn, $sql);

                mysqli_stmt_bind_param($stmt, "s", $img);
                mysqli_stmt_execute($stmt);

                $door = mysqli_stmt_affected_rows($stmt);
            }
        }
    }

    if ($door) {
        '<script language="javascript">';
        'alert("İlan eklenmiştir")';  //not showing an alert box.
        '</script>';
    } else {
        '<script language="javascript">';
        'alert("İlan ekleme  başarısız.")';  //not showing an alert box.
        '</script>';
    }
    header("Refresh:0");
}
?>
<!DOCTYPE html>
<!-- Created by CodingLab |www.youtube.com/c/CodingLabYT-->
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title>  </title>
    <link rel="stylesheet" href="style.css">
    <!-- Boxicons CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:700|Raleway:500.700" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">


    <meta content="width=device-width, initial-scale=1.0" name="viewport">
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
    <link href="assets/css/Slider.css" rel="stylesheet">

    <!--slider linkleri-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="card.css">
    <script src="cards.js"></script>

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

        /* ---------------------------------------------------
    SIDEBAR STYLE
----------------------------------------------------- */

        .wrapper {
            display: flex;
            width: 100%;
            align-items: stretch;
        }

        #sidebar {
            min-width: 250px;
            max-width: 250px;
            background: #7386D5;
            color: #fff;
            transition: all 0.3s;
        }

        #sidebar.active {
            margin-left: -250px;
        }

        #sidebar .sidebar-header {
            padding: 20px;
            background: #6d7fcc;
        }

        #sidebar ul.components {
            padding: 20px 0;
            border-bottom: 1px solid #47748b;
        }

        #sidebar ul p {
            color: #fff;
            padding: 10px;
        }

        #sidebar ul li a {
            padding: 10px;
            font-size: 1.1em;
            display: block;
        }

        #sidebar ul li a:hover {
            color: #7386D5;
            background: #fff;
        }

        #sidebar ul li.active>a,
        a[aria-expanded="true"] {
            color: #fff;
            background: #6d7fcc;
        }

        a[data-toggle="collapse"] {
            position: relative;
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

        #content {
            width: 100%;
            padding: 20px;
            min-height: 100vh;
            transition: all 0.3s;
        }

        @media (max-width: 768px) {
            #sidebar {
                width: 50%;
            }
        }
    </style>
</head>

<body>
    <script>
        function activaTab(tab) {
            $('.nav-tabs a[href="#' + tab + '"]').tab('show');
        };
    </script>
    <section class="home-section">
        <form action="" method="post" enctype="multipart/form-data">
            <div style="padding-left:6%">
                <div style="text-align: center">
                    <h2>Ücretsiz İlan Ekle</h2><br>
                    <hr style="width: 80%;margin-left:10%;border: 1px solid white">
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-10 col-sm-5">
                            <div class="form-group">
                                <label>Ürün Adı</label>
                                <input type="text" class="form-control" name="head_name" required>
                            </div>
                        </div>
                        <div class="col-md-5 col-sm-5">
                            <div class="form-group">
                                <label>Ürün Grubu</label>
                                <select name="product_group" class="form-control" id="grup" onchange="run()" required>
                                    <option value="">Grup</option>
                                    <option value="2">Akü</option>
                                    <option value="3">Jant</option>
                                    <option value="1">Lastik</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-5 col-sm-5">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Fiyatı</label>
                                <input type="number" class="form-control" name="price" placeholder="ör: 17.99" required>
                            </div>
                        </div>
                        <div class="col-md-5 col-sm-5">
                            <div class="form-group">
                                <label>Ürün Ebatı</label>
                                <select name="product_year" class="form-control" id="yıl">
                                    <option value="none" selected disabled="">Ebat</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container">
                    <div class="row">

                        <div class="col-md-5 col-sm-5">
                            <div class="form-group">
                                <label>Ürün markası</label>
                                <select name="product_marka" class="form-control" id="marka" required>
                                    <option value="">Markalar</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-5 col-sm-5">
                            <div class="form-group">
                                <label>Ürün kullanım yeri</label>
                                <select name="product_used" class="form-control" name="alan" id="tür" required>
                                    <option value="">Türler</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-5 col-sm-5">
                            <div class="form-group">
                                <label>Ürünün durumu</label>
                                <select name="product_state" class="form-control" required>
                                    <option value="">Durumu</option>
                                    <option value="0">Sıfır</option>
                                    <option value="1">İkinci el</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-5 col-md-5 ">

                            <div class="form-group">
                                <label class="form-label" for="customFile">Ana resmi seçiniz</label>
                                <input type="file" class="form-control" id="customFile" name="image" required />
                            </div>


                        </div><!-- row -->

                    </div>
                </div>

                <div class="container">
                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>Google Arama Anahtar Kelimeler</label>
                                <input type="text" class="form-control" name="meta" placeholder="Lütfen virgül kullanarak, max 15 anahtar kelime giriniz." required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container" style="padding-top:3%;padding-left:3%">
                    <div class="row">
                        <div>
                            <ul class="nav nav-tabs" style="width: 96%">
                                <li><a href="#aaa" data-toggle="tab">Ürün için daha fazla resim ekle</a></li>
                            </ul>
                            <div class="tab-content" id="tabs">
                                <div class="tab-pane" id="aaa">
                                    <div class="container" style="padding-top:3%">
                                        <div class="row">
                                            <?php for ($i = 1; $i < 10; $i++) { ?>
                                                <div class="form-group col-sm-5">
                                                    <input type="file" class="form-control" id="customFile" name="image<?php $i; ?>" />
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container" style="padding-top:3%">
                    <div class="row">
                        <div class="col-md-10 col-sm-10">
                            <div class="form-group">
                                <label>Ürün Açıklaması</label>
                                <textarea rows="6" class="form-control" name="detay" required placeholder="ürün açıklamasını ekleyiniz..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <br> <br>

                <div class="form-group">
                    <label class="col-md-4 control-label"></label>
                    <div class="col-md-4"><br>
                        <input type="submit" value="İlanı ver" class="btn" style="background-color: #7386D5;width:60%;color:white" name="add">
                    </div>
                </div>
            </div>
        </form>
    </section>
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
            "Achilles",
            "Addo India",
            "Aeolus",
            "Agate",
            "AJS",
            "Alan",
            "Alliance",
            "Altenzo",
            "Altura",
            "Amp Tires",
            "Amtel",
            "Anlas",
            "Annaite",
            "Antares",
            "Anteo",
            "Aoteli",
            "Aplus",
            "Apollo",
            "Aptany",
            "Arestone",
            "Armforce",
            "Armstrong",
            "Arora",
            "Artum",
            "Asya",
            "Atlas",
            "Atrezzo",
            "Austone",
            "Autogrip",
            "Avenger",
            "Barez",
            "Barum",
            "Baysal",
            "Beestone",
            "Belshina",
            "BF Goodrich",
            "Billas",
            "BKT",
            "Blacklion",
            "Blackstone",
            "Blizzard",
            "Boğa Tyres",
            "Bonsun",
            "BossTire",
            "Boto",
            "Bravuris",
            "Bridgestone",
            "Brilliant",
            "Carbon Series",
            "Carlisle",
            "Catch Power",
            "Ceat Iseo",
            "Champiro",
            "Cheng Shin",
            "Chopper",
            "Comfort",
            "Compasal",
            "Constancy",
            "Continental",
            "Cooper",
            "Cordiant",
            "Courier",
            "Cratos",
            "Cultor",
            "Dayton",
            "Debica",
            "Deestone",
            "Delinte",
            "Delitire",
            "Deruibo",
            "Diplomat",
            "Dmack",
            "Dneproshina",
            "Doublestar",
            "Dunlop",
            "Blizzard",
            "Duraturn",
            "Duravis",
            "Duro",
            "Effiplus",
            "ERC",
            "Esa+Tecar",
            "Eurogrip",
            "Eurotyre",
            "Evergreen",
            "Evermax",
            "Falken",
            "Faralong",
            "Farroad",
            "Fate",
            "Federal",
            "Fedima",
            "Feu Vert",
            "Firenza",
            "FireStone",
            "Fisk",
            "Formula Energy",
            "Fronway",
            "Fulda",
            "Fullrun",
            "General Tire",
            "Geroni",
            "Gislaved",
            "Globe Star",
            "Goalstar",
            "Golden Bridge",
            "Goldline",
            "Goodrich",
            "Goodride",
            "Goodyear",
            "Greckster",
            "Greentrac",
            "Gremax",
            "Grenlander",
            "Gripmax",
            "GT Radial",
            "Haida",
            "Hankook",
            "Heidenau",
            "Hercules",
            "Hero",
            "Hifly",
            "Honda",
            "Hoosier",
            "Horng Fortune",
            "Hunter",
            "Imperial",
            "Infinity",
            "Insa Turbo",
            "Interco Tire",
            "Intertrac",
            "IRC",
            "Italmatic",
            "ITP",
            "Jinyu",
            "JK Tyre",
            "Joyroad",
            "Kama",
            "Kapsen",
            "Kelly",
            "Kenda",
            "Kenex",
            "Keter",
            "Kinforest",
            "Kingstar",
            "Kleber",
            "Koçlas",
            "Kooler",
            "Kormoran",
            "KRM",
            "Kumho",
            "Landsail",
            "Lanvigator",
            "Lassa",
            "Laufenn",
            "Linglong",
            "Luhe",
            "Mabor",
            "Marangoni",
            "Marshall",
            "Mastercraft",
            "Matador",
            "Maxam",
            "Maxima",
            "Maxtrek",
            "Maxxis",
            "Mazzini",
            "Membat",
            "Mentor",
            "Metzeler",
            "Michelin",
            "Mickey Thompson",
            "Milestone",
            "Millennium",
            "Minerva",
            "Minnell",
            "Mitas",
            "Mohawk",
            "Momo",
            "Motrio",
            "MRF",
            "Mudstar",
            "Nankang",
            "Neuton",
            "Nexen",
            "Nitto",
            "Nokian",
            "Nordexx",
            "Numa",
            "Orium",
            "Ornet",
            "Otani",
            "Ovation",
            "Özka",
            "Pace",
            "Petlas",
            "Pirelli",
            "Planet",
            "Platin",
            "Pneumant",
            "Point S",
            "Pola",
            "Powerstone",
            "PowerTrac",
            "Premiorri",
            "Presa",
            "Primewell",
            "Radar",
            "Radial",
            "Raiden Tires",
            "Regal",
            "Riken",
            "Roadcruza",
            "Roadstone",
            "Rosava",
            "Rotalla",
            "Rotex",
            "Royal Black",
            "Rubber King",
            "Runway",
            "Saferich",
            "Sailun",
            "Sakura",
            "Sava",
            "Schwalbe",
            "Scudo",
            "Seatta",
            "Sebring",
            "Semperit",
            "Silver Stone",
            "Simex",
            "Solideal",
            "Solido",
            "Solimax",
            "Solitrac",
            "Solus",
            "Sonar",
            "Sonny",
            "Speedways",
            "Spider",
            "Sportiva",
            "Sportrak",
            "Starfire",
            "Starmaxx",
            "Strial",
            "Stunner",
            "Sumitomo",
            "Sumo",
            "Sunbear",
            "SunF",
            "Sunitrac",
            "Sunny",
            "Suntek",
            "Sunwide",
            "Superking",
            "Super Swamper",
            "Swallow",
            "Syron",
            "Talon",
            "Tatko",
            "Taurus",
            "TFT",
            "Three A",
            "Thunderer",
            "Tigar",
            "Tiron",
            "Tokai",
            "Toprunner",
            "Torque",
            "Touring",
            "Tovic",
            "Toyo",
            "Tracmax",
            "Transking",
            "Transporter",
            "Trayal",
            "Tri-Ace",
            "Triangle",
            "Tristar",
            "Tyrex",
            "Unilli",
            "Uniroyal",
            "Vee Rubber",
            "Victorun",
            "Viking",
            "Vitour",
            "Viva",
            "V-Netik",
            "Vredstein",
            "Wanli",
            "Waterfall",
            "Watts",
            "West Lake",
            "Windforce",
            "Winguard",
            "Winrun",
            "Woosung",
            "Wosen",
            "Yamaha",
            "Yatone",
            "Yokohama",
            "Yuanxing",
            "Zeetex",
            "Zestino",
            "Zeta",
            "Zetum",
            "Bosch",
            "Makita",
            "Ceta Form",
            "S-Link",
            "Einhell",
            "Honda",
            "AEG",
            "Yamaha",
            "Ttec",
            "Powermaster",
            "Dewalt",
            "BMW",
            "Klpro",
            "Dremel",
            "3M",
            "Duracell",
            "RTRMAX",
            "Varta",
            "Safir",
            "Max Extra",
            "Hitachi",
            "Ryobi",
            "Yuasa",
            "Tunçmatik",
            "Mutlu",
            "Orbus",
            "Energy",
            "NOVA",
            "Makelsan",
            "Ataba",
            "Çelik",
            "Mervesan",
            "Inform",
            "Vlm Akü",
            "Atex",
            "Erbauer",
            "Ortec",
            "İnci",
            "Presiden",
            "Orion",
            "Volt",
            "Lexron",
            "Abg",
            "Hugel",
            "Yiğit",
            "Diğer",
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
    <script src="script.js"></script>

</body>

</html>