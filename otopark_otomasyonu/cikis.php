<?php
session_start();
session_unset();  // Oturum değişkenlerini temizle
session_destroy(); // Oturumu tamamen bitir

header("Location: giris.php?durum=cikis");
exit;