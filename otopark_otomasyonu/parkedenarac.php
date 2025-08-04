<?php
session_start();
require 'baglan.php';

// Giriş kontrolü
if (!isset($_SESSION['admin']) && !isset($_SESSION['calisan'])) {
    header("Location: giris.php");
    exit;
}

// Mesaj gösterimi
$mesaj = '';
if (isset($_GET['mesaj'])) {
    switch ($_GET['mesaj']) {
        case 'kayit_basarili':
            $mesaj = '<div class="alert alert-success text-center mesaj">Araç başarıyla kaydedildi.</div>';
            break;
        case 'cikis_kaydedildi':
            $mesaj = '<div class="alert alert-success text-center mesaj">Araç çıkışı başarıyla kaydedildi.</div>';
            break;
        case 'silindi':
            $mesaj = '<div class="alert alert-danger text-center mesaj">Kayıt başarıyla silindi.</div>';
            break;
        case 'duzenleme_basarili':
            $mesaj = '<div class="alert alert-success text-center mesaj">Araç bilgileri güncellendi.</div>';
            break;
    }
}

// Tüm araç kayıtlarını çek
$araclar = $db->query("SELECT * FROM arac_kayit ORDER BY arac_id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Park Eden Araçlar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: #f1f3f5;
        }
        .container {
            margin-top: 40px;
        }
        nav a {
            margin-right: 15px;
            font-weight: bold;
        }
        table th, table td {
            vertical-align: middle;
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

<div class="container">
    <h4 class="mb-4 text-center">Park Eden Araçlar</h4>

    <?= $mesaj ?>

    <div class="table-responsive">
        <table class="table table-bordered table-hover text-center align-middle">
            <thead class="table-light">
                <tr>
                    <th>SIRA NO</th>
                    <th>AD-SOYAD</th>
                    <th>TELEFON</th>
                    <th>PLAKA</th>
                    <th>ARAÇ BLOK</th>
                    <th>PARK YERİ</th>
                    <th>GİRİŞ TARİHİ</th>
                    <th>ÇIKIŞ TARİHİ</th>
                    <th>DÜZENLE</th>
                    <th>ARAÇ ÇIKIŞ</th>
                    <th>ÜCRET</th>
                    <th>SİL</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php foreach ($araclar as $arac): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($arac['adsoyad']) ?></td>
                        <td><?= htmlspecialchars($arac['telefon']) ?></td>
                        <td><?= htmlspecialchars($arac['arac_plaka']) ?></td>
                        <td><?= htmlspecialchars($arac['arac_blok']) ?></td>
                        <td><?= htmlspecialchars($arac['arac_park_yeri']) ?></td>
                        <td><?= htmlspecialchars($arac['arac_giris_tarih']) ?></td>
                        <td><?= $arac['arac_cikis_tarih'] ?: '-' ?></td>
                        <td>
                            <a href="duzenle.php?id=<?= $arac['arac_id'] ?>" class="btn btn-warning btn-sm">Düzenle</a>
                        </td>
                        <td>
                            <?php if ($arac['arac_cikis_tarih'] == ''): ?>
                                <a href="araccikis.php?id=<?= $arac['arac_id'] ?>" class="btn btn-danger btn-sm">Araç Çıkış</a>
                            <?php else: ?>
                                <span class="text-muted">Çıkış Yapıldı</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($arac['arac_cikis_tarih'] != ''): ?>
                                <?php
                                // Dakika hesabı
                                $giris = strtotime($arac['arac_giris_tarih']);
                                $cikis = strtotime($arac['arac_cikis_tarih']);
                                $dakika = ceil(($cikis - $giris) / 60);
                                $ucretSorgu = $db->prepare("SELECT ucret FROM ucretler WHERE ? BETWEEN min_sure AND max_sure");
                                $ucretSorgu->execute([$dakika]);
                                $ucret = $ucretSorgu->fetchColumn() ?: 0;
                                ?>
                                <a href="ucret.php?id=<?= $arac['arac_id'] ?>&park_suresi_dakika=<?= $dakika ?>&ucret=<?= $ucret ?>" class="btn btn-info btn-sm">Ücret</a>
                            <?php else: ?>
                                <span class="text-muted">Bekleniyor</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="sil.php?id=<?= $arac['arac_id'] ?>" onclick="return confirm('Bu kaydı silmek istediğinize emin misiniz?');">
                                <img src="https://cdn-icons-png.flaticon.com/512/1214/1214428.png" width="22" title="Sil">
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (count($araclar) === 0): ?>
                    <tr><td colspan="12" class="text-muted">Hiç kayıt bulunamadı.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    // Mesajı 1 saniye sonra gizle
    setTimeout(function() {
        $('.mesaj').fadeOut('slow');
    }, 1000);
</script>

</body>
</html>