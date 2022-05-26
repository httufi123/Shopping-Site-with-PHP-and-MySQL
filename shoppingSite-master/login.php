<?php
session_start();
include "header.php";
?>
<!-- Template Main JS File -->
<script src="assets/js/main.js"></script>
<link href="assets/css/uye_giris.css" rel="stylesheet">

<body>
    <div class="login-wrap">
        <div class="login-html">
            <form action="logincode.php" method="post" enctype="multipart/form-data">
                <input id="tab-1" type="radio" name="tab" class="sign-in" checked><label for="tab-1" class="tab">ÜYE GİRİŞİ</label>
                <input id="tab-2" type="radio" name="tab" class="sign-up"><label for="tab-2" class="tab">KAYIT OL</label>
                <div class="login-form">
                    <div class="sign-in-htm">
                        <div class="group">
                            <label for="user" class="label">Email Adresiniz:</label>
                            <input id="user" type="text" class="input" name="email" required>
                        </div>
                        <div class="group">
                            <label for="pass" class="label">Şifre</label>
                            <input id="pass" type="password" class="input" data-type="password" name="password" required>
                        </div>
                        <div class="group">
                            <input type="submit" class="button" value="Giriş Yap" name="login">
                        </div>
                        <div class="hr"></div>
                    </div>
            </form>
            <form action="code.php" method="post" enctype="multipart/form-data">
                <div class="sign-up-htm">
                    <div class="group">
                        <label for="user" class="label">Adınız</label>
                        <input id="user" type="text" class="input" name="first_name" required>
                    </div>
                    <div class="group">
                        <label for="user" class="label">Kullanıcı Adınız:</label>
                        <input id="user" type="text" class="input" name="username" required>
                    </div>
                    <div class="group">
                        <label for="pass" class="label">Email Adresiniz</label>
                        <input id="pass" type="text" class="input" name="email" required>
                    </div>
                    <div class="group">
                        <label for="pass" class="label">Telefon Numaranız</label>
                        <input id="pass" type="text" class="input" name="phone" required>
                    </div>
                    <div class="group">
                        <select class="form-control" name="city" required>
                            <option value="none" selected="" disabled="">İl</option>
                            <option value="Adana">Adana</option>
                            <option value="Adıyaman">Adıyaman</option>
                            <option value="Afyonkarahisar">Afyonkarahisar</option>
                            <option value="Ağrı">Ağrı</option>
                            <option value="Amasya">Amasya</option>
                            <option value="Ankara">Ankara</option>
                            <option value="Antalya">Antalya</option>
                            <option value="Artvin">Artvin</option>
                            <option value="Aydın">Aydın</option>
                            <option value="Balıkesir">Balıkesir</option>
                            <option value="Bilecik">Bilecik</option>
                            <option value="Bingöl">Bingöl</option>
                            <option value="Bitlis">Bitlis</option>
                            <option value="Bolu">Bolu</option>
                            <option value="Burdur">Burdur</option>
                            <option value="Bursa">Bursa</option>
                            <option value="Çanakkale">Çanakkale</option>
                            <option value="Çankırı">Çankırı</option>
                            <option value="Çorum">Çorum</option>
                            <option value="Denizli">Denizli</option>
                            <option value="Diyarbakır">Diyarbakır</option>
                            <option value="Edirne">Edirne</option>
                            <option value="Elazığ">Elazığ</option>
                            <option value="Erzincan">Erzincan</option>
                            <option value="Erzurum">Erzurum</option>
                            <option value="Eskişehir">Eskişehir</option>
                            <option value="Gaziantep">Gaziantep</option>
                            <option value="Giresun">Giresun</option>
                            <option value="Gümüşhane">Gümüşhane</option>
                            <option value="Hakkari">Hakkâri</option>
                            <option value="Hatay">Hatay</option>
                            <option value="Isparta">Isparta</option>
                            <option value="Mersin">Mersin</option>
                            <option value="İstanbul">İstanbul</option>
                            <option value="İzmir">İzmir</option>
                            <option value="Kars">Kars</option>
                            <option value="Kastamonu">Kastamonu</option>
                            <option value="Kayseri">Kayseri</option>
                            <option value="Kırklareli">Kırklareli</option>
                            <option value="Kırşehir">Kırşehir</option>
                            <option value="Kocaeli">Kocaeli</option>
                            <option value="Konya">Konya</option>
                            <option value="Kütahya">Kütahya</option>
                            <option value="Malatya">Malatya</option>
                            <option value="Manisa">Manisa</option>
                            <option value="Kahramanmaraş">Kahramanmaraş</option>
                            <option value="Mardin">Mardin</option>
                            <option value="Muğla">Muğla</option>
                            <option value="Muş">Muş</option>
                            <option value="Nevşehir">Nevşehir</option>
                            <option value="Niğde">Niğde</option>
                            <option value="Ordu">Ordu</option>
                            <option value="Rize">Rize</option>
                            <option value="Sakarya">Sakarya</option>
                            <option value="Samsun">Samsun</option>
                            <option value="Siirt">Siirt</option>
                            <option value="Sinop">Sinop</option>
                            <option value="Sivas">Sivas</option>
                            <option value="Tekirdağ">Tekirdağ</option>
                            <option value="Tokat">Tokat</option>
                            <option value="Trabzon">Trabzon</option>
                            <option value="Tunceli">Tunceli</option>
                            <option value="Şanlıurfa">Şanlıurfa</option>
                            <option value="Uşak">Uşak</option>
                            <option value="Van">Van</option>
                            <option value="Yozgat">Yozgat</option>
                            <option value="Zonguldak">Zonguldak</option>
                            <option value="Aksaray">Aksaray</option>
                            <option value="Bayburt">Bayburt</option>
                            <option value="Karaman">Karaman</option>
                            <option value="Kırıkkale">Kırıkkale</option>
                            <option value="Batman">Batman</option>
                            <option value="Şırnak">Şırnak</option>
                            <option value="Bartın">Bartın</option>
                            <option value="Ardahan">Ardahan</option>
                            <option value="Iğdır">Iğdır</option>
                            <option value="Yalova">Yalova</option>
                            <option value="Karabük">Karabük</option>
                            <option value="Kilis">Kilis</option>
                            <option value="Osmaniye">Osmaniye</option>
                            <option value="Düzce">Düzce</option>
                        </select>
                        <span class="input-group-addon"><i class="fa fa-home"></i></span>
                    </div>
                    <div class="group">
                        <label for="pass" class="label">Adresiniz</label>
                        <input id="pass" type="text" class="input" name="adress" required>
                    </div>
                    <div class="group">
                        <label for="pass" class="label">Şifre</label>
                        <input id="pass" type="password" class="input" data-type="password" name="password" required>
                    </div>
                    <div class="group">
                        <label for="pass" class="label">Şifreyi Tekrar Giriniz.</label>
                        <input id="pass" type="password" class="input" data-type="password" name="confirm_password" required>
                    </div>
                    <div class="group">
                        <input type="submit" class="button" value="Kayıt Ol" name="register_btn">
                    </div>
                    <div class="hr"></div>
                    <div class="foot-lnk">
                        <label for="tab-1">Zaten Üye Misiniz?</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="alert" style="padding-right:100px">
        <?php
        if (isset($_SESSION['status'])) {
            echo "<h4>" . $_SESSION['status'] . "</h4>";
            unset($_SESSION['status']);
        }
        ?>
    </div>
</body>