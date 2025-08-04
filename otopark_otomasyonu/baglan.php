<?php
$host = 'localhost';
$dbname = 'otopark_otomasyonu';
$username = 'root';
$password = ''; // WAMP için genelde şifre boş olur

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Bağlantı başarılı
} catch (PDOException $e) {
    die("Veritabanı bağlantı hatası: " . $e->getMessage());
}
?>