<?php
include 'baglan.php';

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


    $kullanicisor=$db->prepare("SELECT * FROM users WHERE email=:mail and password=:sifre");
    $kullanicisor->execute(array(
      'mail'=> $_POST['email'],
      'sifre'=> $_POST['password']
    ));
     $sonuc=$kullanicisor->rowCount();
     
     if ($sonuc==0) {
        echo "Mail ya da şifreniz yanlış";
     }else{
        echo "Giriş yapıldı";
        header("location:../index.php");
        $_SESSION['email']= $_POST['email'];
     }

}
/*Oturum Açma İşlemi Giriş*/
/*******************************************************************************/


/*Proje ekle İşlemi Giriş*/
/*******************************************************************************/
if (isset($_POST['projeekle'])) { // PROJE EKLE FORMUNDAN GELİYORSAN
    $projeekle = $db-> prepare("INSERT INTO projects SET 
    project_name=:project_name,
    project_estimated_completion_date=:project_estimated_completion_date,
    project_status=:project_status,
    project_priority=:project_priority,
    project_description=:project_description,
    project_created_at=NOW()");  // 🔥 tarih otomatik ekleniyor
    $projeekle->execute(array(
        'project_name' => $_POST['project_name'],
        'project_estimated_completion_date' => $_POST['project_estimated_completion_date'],
        'project_status' => $_POST['project_status'],
        'project_priority' => $_POST['project_priority'],
        'project_description' => $_POST['project_description'],
        
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

?>