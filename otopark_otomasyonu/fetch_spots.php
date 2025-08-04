<?php
require 'baglan.php';

if (isset($_POST['blok'])) {
    $blok = $_POST['blok'];
    $parklar = [];

    for ($i = 1; $i <= 10; $i++) {
        $kod = $blok[0] . $i;
        $sorgu = $db->prepare("SELECT COUNT(*) FROM arac_kayit WHERE arac_blok = ? AND arac_park_yeri = ? AND arac_cikis_tarih = ''");
        $sorgu->execute([$blok, $kod]);
        $dolu = $sorgu->fetchColumn();

        if ($dolu > 0) {
            echo "<option value='' disabled class='disabled-option'>{$kod} - Dolu</option>";
        } else {
            echo "<option value='{$kod}'>{$kod} - Boş</option>";
        }
    }
}
?>