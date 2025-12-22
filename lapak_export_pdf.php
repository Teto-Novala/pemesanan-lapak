<?php
require('fpdf/fpdf.php');
include 'config.php';
session_start();

if (!isset($_SESSION['admin_logged'])) {
    header('Location: admin_login.php');
    exit;
}

$result = $conn->query("SELECT * FROM lapak ORDER BY id DESC");

class PDF extends FPDF
{
    function Header()
    {
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, 'LAPORAN DATA LAPAK', 0, 1, 'C');

        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 10, 'Dicetak pada: ' . date('d-m-Y H:i:s'), 0, 1, 'C');

        $this->Line(10, 30, 200, 30);
        $this->Ln(10);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Halaman ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

$pdf = new PDF('P', 'mm', 'A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);

$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(200, 220, 255);

$pdf->Cell(10, 10, 'No', 1, 0, 'C', true);
$pdf->Cell(20, 10, 'ID DB', 1, 0, 'C', true);
$pdf->Cell(60, 10, 'Nomor/Nama Lapak', 1, 0, 'L', true);
$pdf->Cell(40, 10, 'Status', 1, 0, 'C', true);
$pdf->Cell(60, 10, 'Keterangan Gambar', 1, 1, 'L', true);

$pdf->SetFont('Arial', '', 10);
$no = 1;

while ($row = $result->fetch_assoc()) {
    $pdf->Cell(10, 10, $no++, 1, 0, 'C');
    $pdf->Cell(20, 10, $row['id'], 1, 0, 'C');
    $pdf->Cell(60, 10, $row['no_lapak'], 1, 0, 'L');

    $status_text = $row['status'];
    $pdf->Cell(40, 10, $status_text, 1, 0, 'C');

    $info_gambar = empty($row['gambar']) ? 'Tidak ada gambar' : 'Ada (Lihat di Web)';
    $pdf->Cell(60, 10, $info_gambar, 1, 1, 'L');
}

$pdf->Output('I', 'Laporan_Lapak.pdf');
