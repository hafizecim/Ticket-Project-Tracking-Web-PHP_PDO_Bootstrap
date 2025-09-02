<?php include 'header.php'; ?>


<?php include 'footer.php'; ?>



<?php
// bu alan sadece not almak kod tekraları için kopyala yapıştırı kolaylaştırmak için
// veri güncellemek istediğinde bu kod yapısını kullanabilirsin -- başlangıç
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
// veri güncellemek istediğinde bu kod yapısını kullanabilirsin -- bitiş
?>

<?php include 'header.php'; ?>


<?php include 'footer.php'; ?>