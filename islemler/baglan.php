<?php 

// ==== CORS Ayarları (Flutter Web için şart) ====
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");


// ==== Veritabanı Bağlantısı ====
$host="localhost"; //Host adınızı girin varsayılan olarak Localhosttur eğer bilginiz yoksa bu şekilde bırakın
$veritabani_ismi="kurs"; //Veritabanı İsminiz
$kullanici_adi="root"; //Veritabanı kullanıcı adınız
$sifre = ""; //Kullanıcı şifreniz şifre yoksa 123456789 yazan yeri silip boş bırakın

try {
	$db=new PDO("mysql:host=$host;dbname=$veritabani_ismi;charset=utf8",$kullanici_adi,$sifre);
	//echo "veritabanı bağlantısı başarılı";
}

catch (PDOExpception $e) {
    echo "veritabanı bağlantısı başarısız";
	echo $e->getMessage();
}

// ==== Flutter ile paylaşılan API Key ====
$api_key = "h1a2f3i4z9e8s7e6n5y4i3l"; // flutter C:\Flutter-Projects\Tutorials\order_project_tracking_application
// sabitler/ext.dart klasöründe   ( const String api_key = "h1a2f3i4z9e8s7e6n5y4i3l"  )

?>