<?php
include 'baglan.php';

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
     }

	
    
}
/*Oturum Açma İşlemi Giriş*/
/*******************************************************************************/

?>