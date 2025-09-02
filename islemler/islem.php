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
                                        site_owner_name=:site_owner_name ");

    // güvenlik için 
    $ayarkaydet->execute(array(
        'site_title' => $_POST['site_title'],
        'site_description' => $_POST['site_description'],
        'site_owner_name' => $_POST['site_owner_name']

    ));

}




/********************************************************************************/
/*Oturum Açma İşlemi Giriş*/
if (isset($_POST['oturumac'])) {

    if (isset($_POST['kul_mail']) and isset($_POST['kul_sifre'])) {
        $kul_mail = guvenlik($_POST['kul_mail']);
        //$kul_sifre = md5($_POST['kul_sifre']);
        $kul_sifre = $_POST['kul_sifre']; // doğrudan gelen şifreyi kullan
        $kullanicisor = $db->prepare("SELECT * FROM users WHERE email=:mail AND password=:sifre");
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
if (isset($_POST['projeekle'])) {
    $projeekle = $db->prepare("INSERT INTO projects SET 
        project_title=:title,
        project_description=:description,
        project_status=:status,
        project_priority=:priority,
        assigned_to_user_id=:assigned_to
    ");
    $projeekle->execute(array(
        'title' => guvenlik($_POST['project_title']),
        'description' => guvenlik($_POST['project_description']),
        'status' => guvenlik($_POST['project_status']),
        'priority' => guvenlik($_POST['project_priority']),
        'assigned_to' => guvenlik($_POST['assigned_to_user_id'])
    ));
}
/*******************************************************************************/
/*Proje ekle İşlemi Giriş*/


/*Proje duzenle İşlemi Giriş*/
/*******************************************************************************/
if (isset($_POST['projeduzenle'])) {
    $projeduzenle = $db->prepare("UPDATE projects SET
        project_title=:title,
        project_description=:description,
        project_status=:status,
        project_priority=:priority,
        assigned_to_user_id=:assigned_to
        WHERE project_id=:project_id
    ");
    $projeduzenle->execute(array(
        'title' => $_POST['project_title'],
        'description' => $_POST['project_description'],
        'status' => $_POST['project_status'],
        'priority' => $_POST['project_priority'],
        'assigned_to' => $_POST['assigned_to_user_id'],
        'project_id' => $_POST['project_id']
    ));
}

/*******************************************************************************/
/*Proje duzenle İşlemi Giriş*/


/*Proje silme İşlemi Giriş*/
/********************************************************************************/

if (isset($_POST['projesilme'])) {
    $sil = $db->prepare("DELETE FROM projects WHERE project_id=:project_id");
    $sil->execute(array('project_id' => $_POST['project_id']));
}


/********************************************************************************/
/*Proje silme İşlemi Giriş*/

/*Sipariş ekle İşlemi Giriş*/
/********************************************************************************/

if (isset($_POST['ticketekle'])) {
    $ticketekle = $db->prepare("INSERT INTO tickets SET
        project_id=:project_id,
        ticket_title=:title,
        ticket_description=:description,
        ticket_status=:status,
        ticket_priority=:priority,
        assigned_to_user_id=:assigned_to
    ");
    $ticketekle->execute(array(
        'project_id' => $_POST['project_id'],
        'title' => $_POST['ticket_title'],
        'description' => $_POST['ticket_description'],
        'status' => $_POST['ticket_status'],
        'priority' => $_POST['ticket_priority'],
        'assigned_to' => $_POST['assigned_to_user_id']
    ));
}



/********************************************************************************/
/*Sipariş ekle İşlemi Giriş*/



/*Sipariş düzenle İşlemi Giriş*/
/********************************************************************************/

if (isset($_POST['ticketduzenle'])) {
    $ticketduzenle = $db->prepare("UPDATE tickets SET
        project_id=:project_id,
        ticket_title=:title,
        ticket_description=:description,
        ticket_status=:status,
        ticket_priority=:priority,
        assigned_to_user_id=:assigned_to
        WHERE ticket_id=:ticket_id
    ");
    $ticketduzenle->execute(array(
        'project_id' => $_POST['project_id'],
        'title' => $_POST['ticket_title'],
        'description' => $_POST['ticket_description'],
        'status' => $_POST['ticket_status'],
        'priority' => $_POST['ticket_priority'],
        'assigned_to' => $_POST['assigned_to_user_id'],
        'ticket_id' => $_POST['ticket_id']
    ));
}



/********************************************************************************/
/*Sipariş düzenle İşlemi Çıkış*/



/*Sipariş silme İşlemi Giriş*/
/********************************************************************************/

if (isset($_POST['ticketsilme'])) {
    $sil = $db->prepare("DELETE FROM tickets WHERE ticket_id=:ticket_id");
    $sil->execute(array('ticket_id' => $_POST['ticket_id']));
}


/********************************************************************************/
/*Sipariş silme İşlemi Giriş*/

