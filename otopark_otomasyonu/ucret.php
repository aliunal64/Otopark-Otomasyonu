<?php   
require_once __DIR__ . '/vendor/autoload.php';
require 'baglan.php';

$arac_id = $_GET['id'];
$park_suresi_dakika = $_GET['park_suresi_dakika'];
$ucret = $_GET['ucret'];

$query = $db->prepare("SELECT * FROM arac_kayit WHERE arac_id = ?");
$query->execute([$arac_id]);
$arac = $query->fetch(PDO::FETCH_ASSOC);

$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->SetMargins(10, 5, 20);
$pdf->SetAutoPageBreak(true, 10);
$pdf->AddPage();
$pdf->SetY(8);

// Ana Başlık 1
$pdf->SetFont('dejavusans', 'B', 13);
$pdf->Cell(0, 8, 'Müşteri ve Araç Bilgisi', 0, 1, 'L');
$pdf->Ln(2);

// Alt başlık fonksiyonu
function yazdirEtiketVeDeger($pdf, $etiket, $deger) {
    $pdf->SetFont('dejavusans', 'B', 11);
    $pdf->Write(6, $etiket . ' ');
    $pdf->SetFont('dejavusans', '', 11);
    $pdf->Write(6, $deger);
    $pdf->Ln(9); // <<< Buradaki değeri 7'den 9'a çıkardık (satır aralığı arttı)
}

// Alt başlıklar
yazdirEtiketVeDeger($pdf, 'Ad Soyad:', $arac['adsoyad'] ?? 'Belirtilmemiş');
yazdirEtiketVeDeger($pdf, 'Telefon:', $arac['telefon'] ?? 'Belirtilmemiş');
yazdirEtiketVeDeger($pdf, 'Plaka:', $arac['arac_plaka'] ?? 'Belirtilmemiş');
yazdirEtiketVeDeger($pdf, 'Giriş Tarihi:', $arac['arac_giris_tarih'] ?? 'Belirtilmemiş');
yazdirEtiketVeDeger($pdf, 'Çıkış Tarihi:', $arac['arac_cikis_tarih'] ?? 'Belirtilmemiş');

$pdf->Ln(6); // Ana başlıklar arası boşluk

// Ana Başlık 2
$pdf->SetFont('dejavusans', 'B', 13);
$pdf->Cell(0, 8, 'Ücret Bilgisi', 0, 1, 'L');
$pdf->Ln(2);

// Alt başlıklar
yazdirEtiketVeDeger($pdf, 'Park Süresi:', $park_suresi_dakika . ' dakika');
yazdirEtiketVeDeger($pdf, 'Ücret:', $ucret . ' TL');

// PDF çıktısı
$pdf->Output('arac_ucreti_' . $arac_id . '.pdf', 'I');
?>
