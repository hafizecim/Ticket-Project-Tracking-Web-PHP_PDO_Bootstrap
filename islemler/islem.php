<?php
include 'baglan.php';
include '../fonksiyonlar.php';

// oturum açma işlemleri güvenlik önlemleri
ob_start();
session_start();

if (isset($_POST['ayarkaydet'])) {  // eğer gele değerler doluysa
    // veri tabanı kayıt işlemi
    $ayarkaydet = $db->prepare("UPDATE sites SET 
                                        site_title=:site_title, 
                                        site_description=:site_description,
                                        site_owner_name=:site_owner_name");

    // güvenlik için 
    $ayarkaydet->execute(array(
        'site_title' => $_POST['site_title'],
        'site_description' => $_POST['site_description'],
        'site_owner_name' => $_POST['site_owner_name']

    ));

}

//Site ayarlarının veri tabanı çekme işlemi
$ayarsor = $db->prepare("SELECT * FROM sites");
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


/********************************************************************************/
/*Oturum Açma İşlemi Giriş*/
if (isset($_POST['oturumac'])) {

    if (isset($_POST['email']) and isset($_POST['password'])) {
        $kul_mail = guvenlik($_POST['email']);
        //$kul_sifre = md5($_POST['kul_sifre']);
        $kul_sifre = $_POST['password']; // doğrudan gelen şifreyi kullan
        $kullanicisor = $db->prepare("SELECT * FROM users WHERE email=:mail and password=:sifre");
        $kullanicisor->execute(array(
            'mail' => $email,
            'sifre' => $password
        ));
        $sonuc = $kullanicisor->rowCount();
        if ($sonuc == 1) {
            $kullanicicek = $kullanicisor->fetch(PDO::FETCH_ASSOC);
            $_SESSION['email'] = sifreleme($email);
            $_SESSION['user_id'] = $kullanicicek['user_id'];

            $ipkaydet = $db->prepare("UPDATE users SET
        ip_address =:ip_address , 
        session_email =:session_email  WHERE 
        email=:email
        ");

            $kaydet = $ipkaydet->execute(array(
                'ip_address' => $_SERVER['REMOTE_ADDR'],
                'session_email' => sifreleme($email),
                'email' => $email
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

?>