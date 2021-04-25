<?php
  //Libraries to read and write PDF metadata
  require_once('tcpdf/tcpdf.php');
  require_once('tcpdf/tcpdi.php');

  // Get submitted meta data fields
  $getFname = $_GET["fname"];
  $getCurrentfname = $_GET["currentfname"];
  $getTitle = $_GET["title"];
  $getAuthor = $_GET["author"];
  $getSubject = $_GET["subject"];
  $getCreator = $_GET["creator"];
  $getKeywords = $_GET["keywords"];

  // Load PDF and move pages from temporary file to final file
  $pdf = new TCPDI(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
  $pdf->AddPage();
  $pdf->setSourceFile($_SERVER['DOCUMENT_ROOT'] . 'uploads/temp-'. $getCurrentfname);
  $idx = $pdf->importPage(1);
  $pdf->useTemplate($idx);
  $pdfdata = file_get_contents($_SERVER['DOCUMENT_ROOT'] . 'uploads/temp-'. $getCurrentfname); 
  $pagecount = $pdf->setSourceData($pdfdata);
  for ($i = 2; $i <= $pagecount; $i++) {
      $tplidx = $pdf->importPage($i);
      $pdf->AddPage();
      $pdf->useTemplate($tplidx);
  }

  // Set file meta data
  $pdf->SetCreator($getCreator);
  $pdf->SetAuthor($getAuthor);
  $pdf->SetTitle($getTitle);
  $pdf->SetSubject($getSubject);
  $pdf->SetKeywords($getKeywords);
  ob_clean();

  // Save file with new file name
	$pdf->Output($_SERVER['DOCUMENT_ROOT'] . 'uploads/'. $getFname, 'F');
  
  // Remove temporary file
  unlink($_SERVER['DOCUMENT_ROOT'] . 'uploads/temp-'. $getCurrentfname);

  // Redirect to home page
  header("Location: index.php");
  exit();
?>