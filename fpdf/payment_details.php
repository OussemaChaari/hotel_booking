<?php

require('../admin/inc/db_config.php');
require('../admin/inc/essentials.php');
adminLogin();

if (isset($_GET['id_payement'])) {
    $req = "SELECT pd.*, uc.*, bo.*
            FROM payment_details pd
            JOIN user_cred uc ON pd.user_id = uc.id
            JOIN booking_order bo ON pd.booking_id = bo.booking_id 
            WHERE id_payement='" . $_GET["id_payement"] . "'";
    $res = mysqli_query($con, $req);

    if (mysqli_num_rows($res) != 0) {
        $row = mysqli_fetch_assoc($res);
        $payment_method = $row['payment_method'];
        $money_to_payer = $row['money_to_payer'];
        $name_user = $row['name'];
        $check_in = $row['check_in'];
        $check_out = $row['check_out'];
    }
}
require('fpdf.php');
class PDF extends FPDF
{
    function Header()
    {
        $this->Image('../logo.png', 10, 5, 140, 20);
        $this->SetY(25);
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 10, 'Payment Invoice', 0, 1, 'C');
        $this->SetLineWidth(0.5);
        $this->Line(10, $this->GetY(), 140, $this->GetY());
        $this->Ln(5);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }
    function ChapterBody($body, $fontSize = 10, $bold = false)
    {
        $this->SetFont('Arial', $bold ? 'B' : '', $fontSize);
        $this->MultiCell(0, 10, $body);
    }
}

$pdf = new PDF('P', 'mm', 'A5');
$pdf->AddPage();

$paragraph = "I hereby confirm that the customer named $name_user has settled the invoice amount.";
$pdf->ChapterBody($paragraph,13,true);

// Header row
$pdf->SetFont('Arial', 'B', 12);

// Data rows
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(40, 10, 'Payment Method', 1);
$pdf->Cell(0, 10, $payment_method, 1, 1);

$pdf->Cell(40, 10, 'Money to Payer', 1);
$pdf->Cell(0, 10, $money_to_payer, 1, 1);

$pdf->Cell(40, 10, 'User Name', 1);
$pdf->Cell(0, 10, $name_user, 1, 1);

$pdf->Cell(40, 10, 'Check In Date', 1);
$pdf->Cell(0, 10, $check_in, 1, 1);

$pdf->Cell(40, 10, 'Check Out Date', 1);
$pdf->Cell(0, 10, $check_out, 1, 1);

$pdf->Ln(10);

$pdf->Output('', '', true);
?>