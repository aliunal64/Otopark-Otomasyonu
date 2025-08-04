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

// Araç kaydını sil
$sil = $db->prepare("DELETE FROM arac_kayit WHERE arac_id = ?");
$sil->execute([$id]);

header("Location: parkedenarac.php?mesaj=silindi");
exit;