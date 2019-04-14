<?php
require_once('TCPDF/tcpdf.php');

// create empty vars
$firstline = $secondline = "";
$num_left = $num_right = $num_ahead = $num_turnleft = $num_turnright = $num_upstairs = $num_downstairs = 0;

// read input from form and assign to vars
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $firstline = test_input($_POST["firstline"]);
  if(isset($_POST["secondline"])) {
    $secondline = test_input($_POST["secondline"]);
  }
  $num_left = test_input($_POST["left"]);
  $num_right = test_input($_POST["right"]);
  $num_ahead = test_input($_POST["ahead"]);

  $num_turnleft = test_input($_POST["turnleft"]);
  $num_turnright = test_input($_POST["turnright"]);

  $num_upstairs = test_input($_POST["upstairs"]);
  $num_downstairs = test_input($_POST["downstairs"]);

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

function createPages($file, $num, $firstline, $secondline, $image, $x, $y, $width, $height) {
  if($num > 0) {
    for ($i=0; $i < $num; $i++) {
      $file->AddPage();
      //Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=0, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='M')
      $file->Cell(0, 0, $firstline, 0, 0, 'C', 0, '', 0);
      $file->Ln(); // line break
      $file->Cell(0, 0, $secondline, 0, 0, 'C', 0, '', 0);
      //Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false)
      $file->Image($image, $x, $y, $width, $height, 'PNG', '', 'B', true, 300, '', false, false, 0, false, false, true);
    }
  }
}

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

$pdf->SetFont('dejavusans', '', 46, '', true);

createPages($pdf, $num_left, $firstline, $secondline, 'img/arrow_left.png', 63, 65, 170, 120);
createPages($pdf, $num_right, $firstline, $secondline, 'img/arrow_right.png', 63, 65, 170, 120);
createPages($pdf, $num_ahead, $firstline, $secondline, 'img/arrow_ahead.png', 63, 65, 170, 120);
createPages($pdf, $num_turnleft, $firstline, $secondline, 'img/arrow_turnleft.png', 78, 65, 170, 120);
createPages($pdf, $num_turnright, $firstline, $secondline, 'img/arrow_turnright.png', 68, 65, 170, 120);
createPages($pdf, $num_upstairs, $firstline, $secondline, 'img/arrow_upstairs.png', 63, 65, 170, 120);
createPages($pdf, $num_downstairs, $firstline, $secondline, 'img/arrow_downstairs.png', 63, 65, 170, 120);

$pdf->Output(strtolower($firstline) . '_wegweiser.pdf', 'D');
?>
