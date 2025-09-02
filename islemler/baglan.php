<?php 

// ==== CORS Ayarları (Flutter Web için) ====
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// ==== Veritabanı Bağlantısı ====
$host = "localhost";               // Host adı
$veritabani_ismi = "helpdesk";     // Veritabanı adı
$kullanici_adi = "root";           // Veritabanı kullanıcı adı
$sifre = "";                        // Şifre (yoksa boş bırakın)

try {
    $db = new PDO(
        "mysql:host=$host;dbname=$veritabani_ismi;charset=utf8",
        $kullanici_adi,
        $sifre,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Hata yakalama modu
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Fetch modu
            PDO::ATTR_EMULATE_PREPARES => false // Hazırlanmış sorgu güvenliği
        ]
    );
    // echo "Veritabanı bağlantısı başarılı"; // Gerekirse debug için
} 
catch (PDOException $e) {
    // Prod ortamda kullanıcıya hata mesajı gösterme, logla
    error_log("Veritabanı bağlantı hatası: " . $e->getMessage());
    die("Veritabanı bağlantısı başarısız!");
}

?>
