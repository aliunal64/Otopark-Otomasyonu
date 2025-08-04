<?php
session_start();
require 'baglan.php';

// Giriş kontrolü
if (!isset($_SESSION['admin']) && !isset($_SESSION['calisan'])) {
    header("Location: giris.php");
    exit;
}

// Araç kaydı
$mesaj = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $adsoyad = $_POST['adsoyad'];
    $telefon = $_POST['telefon'];
    $plaka = strtoupper(trim($_POST['plaka']));
    $blok = $_POST['blok'];
    $park_yeri = $_POST['park_yeri'];

    // Aynı plaka kontrolü
    $kontrol = $db->prepare("SELECT * FROM arac_kayit WHERE arac_plaka = ? AND arac_cikis_tarih = ''");
    $kontrol->execute([$plaka]);

    if ($kontrol->rowCount() > 0) {
        $mesaj = '<div class="alert alert-danger text-center alert-dismissible fade show" role="alert">Girilen plaka otoparkta mevcuttur!</div>';
    } else {
        $kaydet = $db->prepare("INSERT INTO arac_kayit (arac_plaka, arac_blok, adsoyad, telefon, arac_park_yeri, arac_cikis_tarih) VALUES (?, ?, ?, ?, ?, '')");
        $kaydet->execute([$plaka, $blok, $adsoyad, $telefon, $park_yeri]);
        header("Location: parkedenarac.php?mesaj=kayit_basarili");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Araç Kayıt</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: #f1f3f5;
        }
        .form-container {
            max-width: 800px;
            margin: 40px auto;
            background: #fff;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 5px 12px rgba(0,0,0,0.1);
        }
        nav a {
            margin-right: 15px;
            font-weight: bold;
        }
        .disabled-option {
            color: #999 !important;
            background-color: #f8f9fa !important;
        }
        .alert {
            border-radius: 10px;
            transition: opacity 0.5s ease;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light px-4">
    <a class="navbar-brand" href="#">OTOPARK</a>
    <div class="navbar-nav">
        <a class="nav-link" href="arackayit.php">Araç Kayıt</a>
        <a class="nav-link" href="parkedenarac.php">Park Eden Araç</a>
        <a class="nav-link text-danger" href="cikis.php">Çıkış</a>
    </div>
</nav>

<div class="form-container">
    <h4 class="mb-4">Araç Kayıt Formu</h4>

    <?= $mesaj ?>

    <form method="POST" id="aracForm">
        <div class="row mb-3">
            <div class="col-md-6">
                <label>Ad Soyad</label>
                <input type="text" name="adsoyad" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label>Telefon</label>
                <input type="text" name="telefon" class="form-control" required>
            </div>
        </div>

        <div class="mb-3">
            <label>Plaka</label>
            <input type="text" name="plaka" class="form-control text-uppercase" required>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label>Blok Seçiniz</label>
                <select name="blok" id="blok" class="form-select" required>
                    <option value="">Blok Seçiniz</option>
                    <?php
                    $bloklar = ['A', 'B', 'C', 'D'];
                    foreach ($bloklar as $blok) {
                        $sayac = $db->prepare("SELECT COUNT(*) FROM arac_kayit WHERE arac_blok = ? AND arac_cikis_tarih = ''");
                        $sayac->execute([$blok . ' BLOK']);
                        $doluluk = $sayac->fetchColumn();
                        echo "<option value='{$blok} BLOK'>{$blok} BLOK ({$doluluk}/10)</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-6">
                <label>Park Yeri</label>
                <select name="park_yeri" id="park_yeri" class="form-select" required>
                    <option value="">Önce blok seçiniz</option>
                </select>
            </div>
        </div>

        <div class="text-end">
            <button type="reset" class="btn btn-secondary">Sıfırla</button>
            <button type="submit" class="btn btn-success">Kaydet</button>
        </div>
    </form>
</div>

<!-- Park yeri verilerini dinamik yükle -->
<script>
$(document).ready(function() {
    $('#blok').change(function() {
        var blok = $(this).val();
        if (blok !== '') {
            $.ajax({
                url: 'fetch_spots.php',
                type: 'POST',
                data: { blok: blok },
                success: function(data) {
                    $('#park_yeri').html(data);
                }
            });
        } else {
            $('#park_yeri').html('<option value="">Önce blok seçiniz</option>');
        }
    });

    // 1 saniye sonra mesajı sil
    setTimeout(() => {
        const alert = document.querySelector('.alert');
        if (alert) {
            alert.style.opacity = '0';
            setTimeout(() => {
                alert.remove();
            }, 500);
        }
    }, 1000);
});
</script>

</body>
</html>
