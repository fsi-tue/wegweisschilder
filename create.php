<?php
require_once('TCPDF/tcpdf.php');

// create empty vars
$firstline = $secondline = "";
$num_left = $num_right = $num_ahead = 0;

// read input from form and assign to vars
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $firstline = test_input($_POST["firstline"]);
  if(isset($_POST["secondline"])) {
    $secondline = test_input($_POST["secondline"]);
  }
  $num_left = test_input($_POST["left"]);
  $num_right = test_input($_POST["right"]);
  $num_ahead = test_input($_POST["ahead"]);
} else {
  echo("Keine Daten eingegeben!");
  return false;
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

// create PDF file
$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false); // L=landscape

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

$pdf->SetFont('dejavusans', '', 48, '', true);
for ($i=0; $i < $num_left; $i++) {
  $pdf->AddPage();
  //Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=0, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='M')
  $pdf->Cell(0, 0, $firstline, 0, 0, 'C', 0, '', 0);
  $pdf->Ln(); // line break
  $pdf->Cell(0, 0, $secondline, 0, 0, 'C', 0, '', 0);
  //Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false)
  $pdf->Image('img/arrow_left.png', 70, 120, 150, 60, 'PNG', '', 'B', true, 300, '', false, false, 0, false, false, true);
}

for ($i=0; $i < $num_right; $i++) {
  $pdf->AddPage();
  $pdf->Cell(0, 0, $firstline, 0, 0, 'C', 0, '', 0);
  $pdf->Ln();
  $pdf->Cell(0, 0, $secondline, 0, 0, 'C', 0, '', 0);
  $pdf->Image('img/arrow_right.png', 70, 120, 150, 60, 'PNG', '', 'B', true, 300, '', false, false, 0, false, false, true);
}

for ($i=0; $i < $num_ahead; $i++) {
  $pdf->AddPage();
  $pdf->Cell(0, 0, $firstline, 0, 0, 'C', 0, '', 0);
  $pdf->Ln();
  $pdf->Cell(0, 0, $secondline, 0, 0, 'C', 0, '', 0);
  $pdf->Image('img/arrow_ahead.png', 120, 80, 60, 100, 'PNG', '', 'B', true, 300, '', false, false, 0, false, false, true);
}

$pdf->Output(strtolower($firstline) . '_wegweiser.pdf', 'D');
?>
