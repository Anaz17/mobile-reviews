<?php
require('fpdf/fpdf.php');
include 'db.php';

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Title
$pdf->Cell(0, 10, 'Mobile App Reviews', 0, 1, 'C');
$pdf->Ln(5);

// Table Header
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetFillColor(200, 220, 255);
$pdf->Cell(10, 10, 'ID', 1, 0, 'C', true);
$pdf->Cell(40, 10, 'App Name', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Category', 1, 0, 'C', true);
$pdf->Cell(60, 10, 'Content', 1, 0, 'C', true); // ✅ fixed quote
$pdf->Cell(25, 10, 'Status', 1, 1, 'C', true);

// Get reviews from database
$query = "SELECT * FROM reviews ORDER BY id ASC";
$result = $conn->query($query);
$pdf->SetFont('Arial', '', 11);

while ($row = $result->fetch_assoc()) {
    $pdf->Cell(10, 10, $row['id'], 1);
    $pdf->Cell(40, 10, substr($row['title'], 0, 25), 1);
    $pdf->Cell(30, 10, substr($row['category'], 0, 20), 1);

    $desc = substr($row['content'], 0, 50) . (strlen($row['content']) > 50 ? '...' : '');
    $pdf->Cell(60, 10, $desc, 1);

    if ($row['is_active'] == 1) {
        $pdf->SetTextColor(0, 128, 0); // green
        $status = 'Active';
    } else {
        $pdf->SetTextColor(220, 20, 60); // red
        $status = 'Inactive';
    }

    $pdf->Cell(25, 10, $status, 1, 1);
    $pdf->SetTextColor(0, 0, 0); // reset to black
}

// Output PDF (force download)
$pdf->Output('D', 'mobile_app_reviews.pdf');
?>
