<?php
require('fpdf/fpdf.php');
include 'config.php';
session_start();

if (!isset($_SESSION['admin_logged']) || $_SESSION['admin_logged'] !== true) {
    header('Location: admin_login.php');
    exit;
}

$pesanans = $conn->query("SELECT * FROM pesanan ORDER BY id DESC");

class PDF extends FPDF
{
    function Header()
    {
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, 'LAPORAN DAFTAR PESANAN', 0, 1, 'C');

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
$pdf->SetFillColor(52, 152, 219);
$pdf->SetTextColor(255);

$pdf->Cell(10, 10, 'No', 1, 0, 'C', true);
$pdf->Cell(50, 10, 'Nama Pemesan', 1, 0, 'L', true);
$pdf->Cell(40, 10, 'Tanggal', 1, 0, 'C', true);
$pdf->Cell(40, 10, 'No Lapak', 1, 0, 'C', true);
$pdf->Cell(50, 10, 'Status', 1, 1, 'C', true);

$pdf->SetFont('Arial', '', 10);
$pdf->SetTextColor(0);

$no = 1;

while ($p = $pesanans->fetch_assoc()) {
    $pdf->Cell(10, 10, $no++, 1, 0, 'C');

    $pdf->Cell(50, 10, $p['username'], 1, 0, 'L');
    $pdf->Cell(40, 10, $p['tanggal'], 1, 0, 'C');
    $pdf->Cell(40, 10, $p['no_lapak'], 1, 0, 'C');

    $status = ucfirst($p['status']);
    $pdf->Cell(50, 10, $status, 1, 1, 'C');
}

$pdf->Output('I', 'Laporan_Pesanan.pdf');
