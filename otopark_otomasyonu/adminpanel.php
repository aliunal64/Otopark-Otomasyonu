<?php
session_start();
require 'baglan.php';

// Admin kontrolü
if (!isset($_SESSION['admin'])) {
    header("Location: giris.php");
    exit;
}

// Bildirim mesajı
$mesaj = '';
if (isset($_GET['mesaj'])) {
    switch ($_GET['mesaj']) {
        case 'calisan_eklendi':
            $mesaj = '<div class="alert alert-success text-center alert-dismissible fade show" role="alert">Çalışan başarıyla kaydedildi.</div>';
            break;
        case 'ucret_guncellendi':
            $mesaj = '<div class="alert alert-success text-center alert-dismissible fade show" role="alert">Ücret başarıyla güncellendi.</div>';
            break;
        case 'hata':
            $mesaj = '<div class="alert alert-danger text-center alert-dismissible fade show" role="alert">Bir hata oluştu.</div>';
            break;
    }
}

// Çalışan ekleme
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['calisan_ekle'])) {
    $adsoyad = $_POST['adsoyad'];
    $mail = $_POST['mail'];
    $sifre = $_POST['sifre'];

    $stmt = $db->prepare("INSERT INTO kullanici_giris (adsoyad, mail, sifre, supervisor, giris_turu, onay) VALUES (?, ?, ?, 0, 'calisan', 1)");
    $stmt->execute([$adsoyad, $mail, $sifre]);
    header("Location: adminpanel.php?mesaj=calisan_eklendi");
    exit;
}

// Ücret güncelleme
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ucret_guncelle'])) {
    $id = $_POST['id'];
    $min = $_POST['min_sure'];
    $max = $_POST['max_sure'];
    $ucret = $_POST['ucret'];

    $stmt = $db->prepare("UPDATE ucretler SET min_sure = ?, max_sure = ?, ucret = ? WHERE id = ?");
    $stmt->execute([$min, $max, $ucret, $id]);
    header("Location: adminpanel.php?mesaj=ucret_guncellendi");
    exit;
}

// Ücretleri çek
$ucretler = $db->query("SELECT * FROM ucretler ORDER BY min_sure ASC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Admin Paneli</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        .panel-container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 25px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        h3 {
            font-weight: bold;
        }
        .form-section {
            margin-bottom: 40px;
        }
        .alert {
            border-radius: 10px;
            transition: opacity 0.5s ease;
        }
    </style>
</head>
<body>

<div class="container panel-container">
    <h3 class="text-center mb-4">Admin Paneli</h3>

    <?= $mesaj ?>

    <div class="mb-4 text-end">
        <a href="giris.php" class="btn btn-secondary">Giriş Ekranına Dön</a>
    </div>

    <!-- Çalışan Ekleme -->
    <div class="form-section">
        <h5>Çalışan Kaydı</h5>
        <form method="POST">
            <input type="hidden" name="calisan_ekle" value="1">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <input type="text" name="adsoyad" class="form-control" placeholder="Ad Soyad" required>
                </div>
                <div class="col-md-4 mb-3">
                    <input type="email" name="mail" class="form-control" placeholder="E-Mail" required>
                </div>
                <div class="col-md-4 mb-3">
                    <input type="text" name="sifre" class="form-control" placeholder="Şifre" required>
                </div>
            </div>
            <button type="submit" class="btn btn-success">Çalışanı Kaydet</button>
        </form>
    </div>

    <!-- Ücret Güncelleme -->
    <div class="form-section">
        <h5>Ücret Tablosu</h5>
        <div class="table-responsive">
            <table class="table table-bordered align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>Süre (dk)</th>
                        <th>Ücret (TL)</th>
                        <th>İşlem</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ucretler as $ucret): ?>
                        <tr>
                            <form method="POST">
                                <input type="hidden" name="ucret_guncelle" value="1">
                                <input type="hidden" name="id" value="<?= $ucret['id'] ?>">
                                <td class="d-flex gap-2 justify-content-center">
                                    <input type="number" name="min_sure" value="<?= $ucret['min_sure'] ?>" class="form-control" style="width: 90px;" required>
                                    <span class="pt-2">-</span>
                                    <input type="number" name="max_sure" value="<?= $ucret['max_sure'] ?>" class="form-control" style="width: 90px;" required>
                                </td>
                                <td>
                                    <input type="number" name="ucret" value="<?= $ucret['ucret'] ?>" class="form-control" style="width: 120px;" required>
                                </td>
                                <td>
                                    <button type="submit" class="btn btn-primary">Güncelle</button>
                                </td>
                            </form>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    setTimeout(() => {
        const alert = document.querySelector('.alert');
        if (alert) {
            alert.style.opacity = '0';
            setTimeout(() => {
                alert.remove();
            }, 500);
        }
    }, 1000);
</script>

</body>
</html>