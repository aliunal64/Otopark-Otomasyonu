<?php
session_start();
require 'baglan.php';

if (!isset($_SESSION['admin']) && !isset($_SESSION['calisan'])) {
    header("Location: giris.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: parkedenarac.php");
    exit;
}

$id = $_GET['id'];
$arac = $db->prepare("SELECT * FROM arac_kayit WHERE arac_id = ?");
$arac->execute([$id]);
$arac = $arac->fetch(PDO::FETCH_ASSOC);

if (!$arac) {
    echo "<div class='alert alert-danger text-center mt-4'>Kayıt bulunamadı.</div>";
    exit;
}

$mesaj = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $adsoyad = trim($_POST['adsoyad']);
    $telefon = trim($_POST['telefon']);
    $arac_blok = trim($_POST['arac_blok']);
    $arac_park_yeri = trim($_POST['arac_park_yeri']);

    $guncelle = $db->prepare("UPDATE arac_kayit SET adsoyad = ?, telefon = ?, arac_blok = ?, arac_park_yeri = ? WHERE arac_id = ?");
    $guncelle->execute([$adsoyad, $telefon, $arac_blok, $arac_park_yeri, $id]);

    // Mesaj + 1 saniyede yönlendirme
    $mesaj = "<div class='alert alert-success text-center'>Bilgiler başarıyla güncellendi. Yönlendiriliyorsunuz...</div>";
    echo "<script>
        setTimeout(function() {
            window.location.href = 'parkedenarac.php?mesaj=duzenleme_basarili';
        }, 1000);
    </script>";
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Araç Bilgileri Düzenle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <style>
        body {
            background: #f1f3f5;
            font-family: 'Roboto', sans-serif;
        }
        .box {
            max-width: 600px;
            margin: 50px auto;
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

<div class="box">
    <h4>Araç Bilgilerini Düzenle</h4>
    <hr>

    <?= $mesaj ?>

    <?php if ($_SERVER["REQUEST_METHOD"] !== "POST"): ?>
    <form method="POST">
        <div class="mb-3">
            <label>Ad Soyad</label>
            <input type="text" name="adsoyad" class="form-control" value="<?= htmlspecialchars($arac['adsoyad']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Telefon</label>
            <input type="text" name="telefon" class="form-control" value="<?= htmlspecialchars($arac['telefon']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Blok</label>
            <input type="text" name="arac_blok" class="form-control" value="<?= htmlspecialchars($arac['arac_blok']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Park Yeri</label>
            <input type="text" name="arac_park_yeri" class="form-control" value="<?= htmlspecialchars($arac['arac_park_yeri']) ?>" required>
        </div>

        <div class="text-end">
            <a href="parkedenarac.php" class="btn btn-secondary">İptal</a>
            <button type="submit" class="btn btn-primary">Güncelle</button>
        </div>
    </form>
    <?php endif; ?>
</div>

<script>
    // Mesajı 1 saniye sonra gizle
    $(document).ready(function () {
        setTimeout(function () {
            $(".alert").fadeOut("fast");
        }, 1000);
    });
</script>

</body>
</html>
