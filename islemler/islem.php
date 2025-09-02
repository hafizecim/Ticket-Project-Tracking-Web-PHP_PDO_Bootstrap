<?php
include 'baglan.php';
include '../fonksiyonlar.php';

// oturum açma işlemleri güvenlik önlemleri
ob_start();
session_start();

if (isset($_POST['ayarkaydet'])) {  // eğer gele değerler doluysa
    // veri tabanı kayıt işlemi
    $ayarkaydet = $db->prepare("UPDATE ayarlar SET 
                                        site_baslik=:site_baslik, 
                                        site_aciklama=:site_aciklama,
                                        site_sahibi=:site_sahibi ");

    // güvenlik için 
    $ayarkaydet->execute(array(
        'site_baslik' => $_POST['site_baslik'],
        'site_aciklama' => $_POST['site_aciklama'],
        'site_sahibi' => $_POST['site_sahibi']

    ));

}

//Site ayarlarının veri tabanı çekme işlemi
$ayarsor = $db->prepare("SELECT * FROM ayarlar");
$ayarsor->execute();
$ayarcek = $ayarsor->fetch(PDO::FETCH_ASSOC);

if (isset($_GET["api_key"])) {
    if ($_GET["api_key"] == $api_key) {
        $api = true;
    } else {
        echo json_encode(['durum' => 'no', 'mesaj' => "API Bilgileriniz hatalıdır."]);
        $api = false;
    }
} else {
    $api = true;
}

/*
// DEBUG: Flutter'dan gelen POST ve GET verilerini göster
var_dump($_POST);
var_dump($_GET);
exit; // Kod burda durur, geri kalan sorgular çalışmaz

*/

/********************************************************************************/
/*Oturum Açma İşlemi Giriş*/
if (isset($_POST['oturumac'])) {

    if (isset($_POST['kul_mail']) and isset($_POST['kul_sifre'])) {
        $kul_mail = guvenlik($_POST['kul_mail']);
        //$kul_sifre = md5($_POST['kul_sifre']);
        $kul_sifre = $_POST['kul_sifre']; // doğrudan gelen şifreyi kullan
        $kullanicisor = $db->prepare("SELECT * FROM kullanici WHERE kul_mail=:mail and kul_sifre=:sifre");
        $kullanicisor->execute(array(
            'mail' => $kul_mail,
            'sifre' => $kul_sifre
        ));
        $sonuc = $kullanicisor->rowCount();
        if ($sonuc == 1) {
            $kullanicicek = $kullanicisor->fetch(PDO::FETCH_ASSOC);
            $_SESSION['kul_mail'] = sifreleme($kul_mail);
            $_SESSION['kul_id'] = $kullanicicek['kul_id'];

            $ipkaydet = $db->prepare("UPDATE kullanici SET
        ip_adresi=:ip_adresi, 
        session_mail=:session_mail WHERE 
        kul_mail=:kul_mail
        ");

            $kaydet = $ipkaydet->execute(array(
                'ip_adresi' => $_SERVER['REMOTE_ADDR'],
                'session_mail' => sifreleme($kul_mail),
                'kul_mail' => $kul_mail
            ));

            if ($api) {
                // header('Content-Type: application/json; charset=utf-8'); // JSON başlık
                echo json_encode([
                    'durum' => 'ok',
                    'bilgiler' => $kullanicicek
                ]);
                //exit;
            } else {
                header("location:../index.php");
                //exit;
            }

            exit;
        } else {
            if ($api) {
                //header('Content-Type: application/json; charset=utf-8');
                echo json_encode([
                    'durum' => 'no',
                    'mesaj' => 'Giriş Bilgileriniz Hatalı'
                ]);
            } else {
                header("location:../giris?durum=hata");
            }
        }
    } else {
        echo json_encode([
            'durum' => 'no',
            'mesaj' => 'Mail veya Şifre Parametreleri Boş'
        ]);
    }

    exit;
}
/*******************************************************************************/
/*Oturum Açma İşlemi Giriş*/



/*Proje ekle İşlemi Giriş*/
/*******************************************************************************/
if (isset($_POST['projeekle'])) { // PROJE EKEL FORMUNDAN GELİYORSAN
    $projeekle = $db->prepare("INSERT INTO proje SET 
    proje_baslik=:baslik,
    proje_teslim_tarihi=:teslim_tarih,
    proje_aciliyet=:aciliyet,
    proje_durum=:durum,
    proje_detay=:detay");
    $projeekle->execute(array(
        'baslik' => guvenlik($_POST['proje_baslik']),
        'teslim_tarih' => guvenlik($_POST['proje_teslim_tarihi']),
        'aciliyet' => guvenlik($_POST['proje_aciliyet']),
        'durum' => guvenlik($_POST['proje_durum']),
        'detay' => guvenlik($_POST['proje_detay'])
    ));


    $yuklemeklasoru = '../dosyalar';
    @$gecici_isim = $_FILES['proje_dosya']["tmp_name"];
    @$dosya_ismi = $_FILES['proje_dosya']["name"];
    $benzersizsayi1 = rand(100000, 999999);
    $isim = tr_degistirme($benzersizsayi1 . $_POST['proje_baslik'] . $dosya_ismi);
    $resim_yolu = substr($yuklemeklasoru, 3) . "/" . $isim;
    @move_uploaded_file($gecici_isim, "$yuklemeklasoru/$isim");

    $son_eklenen_id = $db->lastInsertId();

    $dosyayukleme = $db->prepare("UPDATE proje SET
     dosya_yolu=:dosya_yolu   WHERE proje_id=:proje_id ");

    $yukleme = $dosyayukleme->execute(array(
        'dosya_yolu' => $resim_yolu,
        'proje_id' => $son_eklenen_id
    ));




    if ($projeekle) {
        header("location:../index.php");
    } else {
        echo "Başarız";
        exit;
    }
}
/*******************************************************************************/
/*Proje ekle İşlemi Giriş*/


/*Proje duzenle İşlemi Giriş*/
/*******************************************************************************/
if (isset($_POST['projeduzenle'])) { // PROJE EKEL FORMUNDAN GELİYORSAN
    $projeduzenle = $db->prepare("UPDATE proje SET 
    proje_baslik=:baslik,
    proje_teslim_tarihi=:teslim_tarih,
    proje_aciliyet=:aciliyet,
    proje_durum=:durum,
    proje_detay=:detay
    WHERE proje_id=:proje_id"
    );
    $projeduzenle->execute(array(
        'baslik' => $_POST['proje_baslik'],
        'teslim_tarih' => $_POST['proje_teslim_tarihi'],
        'aciliyet' => $_POST['proje_aciliyet'],
        'durum' => $_POST['proje_durum'],
        'detay' => $_POST['proje_detay'],
        'proje_id' => $_POST['proje_id']
    ));


    $yuklemeklasoru = '../dosyalar';
    @$gecici_isim = $_FILES['proje_dosya']["tmp_name"];
    @$dosya_ismi = $_FILES['proje_dosya']["name"];
    $benzersizsayi1 = rand(100000, 999999);
    $isim = tr_degistirme($benzersizsayi1 . $_POST['proje_baslik'] . $dosya_ismi);
    $resim_yolu = substr($yuklemeklasoru, 3) . "/" . $isim;
    @move_uploaded_file($gecici_isim, "$yuklemeklasoru/$isim");


    $dosyayukleme = $db->prepare("UPDATE proje SET
     dosya_yolu=:dosya_yolu    WHERE proje_id=:proje_id ");

    $yukleme = $dosyayukleme->execute(array(
        'dosya_yolu' => $resim_yolu,
        'proje_id' => $_POST['proje_id']
    ));


    if ($projeduzenle) {
        header("location:../index.php");
    } else {
        echo "Başarız";
        exit;
    }
}
/*******************************************************************************/
/*Proje duzenle İşlemi Giriş*/


/*Proje silme İşlemi Giriş*/
/********************************************************************************/

if (isset($_POST['projesilme'])) {
    $sil = $db->prepare("DELETE from proje where proje_id=:proje_id");
    $kontrol = $sil->execute(array(
        'proje_id' => $_POST['proje_id']
    ));

    if ($kontrol) {
        //echo "kayıt başarılı";
        header("location:../projeler.php");
    } else {
        echo "kayıt başarısız";
        exit;
    }
}

/********************************************************************************/
/*Proje silme İşlemi Giriş*/

/*Sipariş ekle İşlemi Giriş*/
/********************************************************************************/

if (isset($_POST['siparisekle'])) {
    $siparisekle = $db->prepare("INSERT INTO siparis SET
    musteri_isim=:isim,
    musteri_mail=:mail,
    musteri_telefon=:telefon,
    sip_baslik=:baslik,
    sip_teslim_tarihi=:teslim_tarihi,
    sip_aciliyet=:aciliyet,
    sip_durum=:durum,
    sip_ucret=:ucret,
    sip_detay=:detay
    /*yuzde=:yuzde,*/
    /*sip_baslama_tarih=:sip_baslama_tarih  */
    ");

    $siparisekle->execute(array(
        'isim' => $_POST['musteri_isim'],
        'mail' => $_POST['musteri_mail'],
        'telefon' => $_POST['musteri_telefon'],
        'baslik' => $_POST['sip_baslik'],
        'teslim_tarihi' => $_POST['sip_teslim_tarihi'],
        'aciliyet' => $_POST['sip_aciliyet'],
        'durum' => $_POST['sip_durum'],
        'ucret' => $_POST['sip_ucret'],
        'detay' => $_POST['sip_detay']
        /*'yuzde' => $_POST['yuzde'], */
        /*'sip_baslama_tarih' => $_POST['sip_baslama_tarih']*/
    ));


    $yuklemeklasoru = '../dosyalar';
    @$gecici_isim = $_FILES['siparis_dosya']["tmp_name"];
    @$dosya_ismi = $_FILES['siparis_dosya']["name"];
    $benzersizsayi1 = rand(100000, 999999);
    $isim = tr_degistirme($benzersizsayi1 . $_POST['sip_baslik'] . $dosya_ismi);
    $resim_yolu = substr($yuklemeklasoru, 3) . "/" . $isim;
    @move_uploaded_file($gecici_isim, "$yuklemeklasoru/$isim");

    $son_eklenen_id = $db->lastInsertId();

    $dosyayukleme = $db->prepare("UPDATE siparis SET
     dosya_yolu=:dosya_yolu   WHERE sip_id=:sip_id ");

    $yukleme = $dosyayukleme->execute(array(
        'dosya_yolu' => $resim_yolu,
        'sip_id' => $son_eklenen_id
    ));

    if ($siparisekle) {
        //echo "kayıt başarılı";
        header("location:../index.php");
    } else {
        echo "kayıt başarısız";
        exit;
    }
}

/********************************************************************************/
/*Sipariş ekle İşlemi Giriş*/



/*Sipariş düzenle İşlemi Giriş*/
/********************************************************************************/

if (isset($_POST['siparisduzenle'])) {
    $siparisduzenle = $db->prepare("UPDATE siparis SET
        musteri_isim=:isim,
        musteri_mail=:mail,
        musteri_telefon=:telefon,
        sip_baslik=:baslik,
        sip_teslim_tarihi=:teslim_tarihi,
        sip_aciliyet=:aciliyet,
        sip_durum=:durum,
        sip_ucret=:ucret,
        sip_detay=:detay
        WHERE sip_id=:sip_id
    ");

    $siparisduzenle->execute(array(
        'isim' => $_POST['musteri_isim'],
        'mail' => $_POST['musteri_mail'],
        'telefon' => $_POST['musteri_telefon'],
        'baslik' => $_POST['sip_baslik'],
        'teslim_tarihi' => $_POST['sip_teslim_tarihi'],
        'aciliyet' => $_POST['sip_aciliyet'],
        'durum' => $_POST['sip_durum'],
        'ucret' => $_POST['sip_ucret'],
        'detay' => $_POST['sip_detay'],
        'sip_id' => $_POST['sip_id']  // HIDDEN INPUT’TAN GELİYOR 
    ));


    $yuklemeklasoru = '../dosyalar';
    @$gecici_isim = $_FILES['siparis_dosya']["tmp_name"];
    @$dosya_ismi = $_FILES['siparis_dosya']["name"];
    $benzersizsayi1 = rand(100000, 999999);
    $isim = tr_degistirme($benzersizsayi1 . $_POST['sip_baslik'] . $dosya_ismi);
    $resim_yolu = substr($yuklemeklasoru, 3) . "/" . $isim;
    @move_uploaded_file($gecici_isim, "$yuklemeklasoru/$isim");


    $dosyayukleme = $db->prepare("UPDATE siparis SET
     dosya_yolu=:dosya_yolu   WHERE sip_id=:sip_id ");

    $yukleme = $dosyayukleme->execute(array(
        'dosya_yolu' => $resim_yolu,
        'sip_id' => $_POST['sip_id']
    ));

    if ($siparisduzenle) {
        header("location:../index.php");
    } else {
        echo "Sipariş güncelleme başarısız!";
        exit;
    }
}

/********************************************************************************/
/*Sipariş düzenle İşlemi Çıkış*/



/*Sipariş silme İşlemi Giriş*/
/********************************************************************************/

if (isset($_POST['siparissilme'])) {
    $sil = $db->prepare("DELETE from siparis where sip_id=:sip_id");
    $kontrol = $sil->execute(array(
        'sip_id' => $_POST['sip_id']
    ));

    if ($kontrol) {
        //echo "kayıt başarılı";
        header("location:../siparisler.php");
    } else {
        echo "kayıt başarısız";
        exit;
    }
}

/********************************************************************************/
/*Sipariş silme İşlemi Giriş*/




/************************** Flutter için ***********************************************/

if (isset($_POST['projeleri_getir'])) {
  if(!$api){
    echo json_encode(['durum' => 'no','mesaj'=>'API Bilgileriniz Eksik']);
  } else {

    if (isset($_POST['sirala'])) {
      $order="ORDER BY ".guvenlik($_POST['sirala']);
    } else {
      $order="";
    }

    if (isset($_POST['limit'])) {
      $limit="LIMIT ".guvenlik($_POST['limit']);
    } else {
      $limit="";
    }


    $x=$db->prepare("SELECT * FROM proje $order $limit");
    $x->execute();
    $sonuc=$x->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['durum' => 'ok', 'projeler' => $sonuc],JSON_NUMERIC_CHECK | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);

  }
}


if (isset($_POST['siparisleri_getir'])) {
  if(!$api){
    echo json_encode(['durum' => 'no','mesaj'=>'API Bilgileriniz Eksik']);
  } else {

   if (isset($_POST['sirala'])) {
    $order="ORDER BY ".guvenlik($_POST['sirala']);
  } else {
    $order="";
  }

  if (isset($_POST['limit'])) {
    $limit="LIMIT ".guvenlik($_POST['limit']);
  } else {
    $limit="";
  }

  $x=$db->prepare("SELECT * FROM siparis $order $limit");
  $x->execute();
  $sonuc=$x->fetchAll(PDO::FETCH_ASSOC);
  echo json_encode(['durum' => 'ok', 'siparisler' => $sonuc],JSON_NUMERIC_CHECK | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);

}
}



if (isset($_POST['projeguncelle'])) {
    $projeduzenle = $db->prepare("UPDATE proje SET 
        proje_baslik=:baslik,
        proje_teslim_tarihi=:teslim_tarih,
        proje_aciliyet=:aciliyet,
        proje_durum=:durum,
        proje_detay=:detay
        WHERE proje_id=:proje_id"
    );
    $projeduzenle->execute(array(
        'baslik' => $_POST['proje_baslik'],
        'teslim_tarih' => $_POST['proje_teslim_tarihi'],
        'aciliyet' => $_POST['proje_aciliyet'],
        'durum' => $_POST['proje_durum'],
        'detay' => $_POST['proje_detay'],
        'proje_id' => $_POST['proje_id']
    ));

    echo json_encode(['durum'=>'ok','mesaj'=>'Proje güncellendi']);
    exit;
}




?>