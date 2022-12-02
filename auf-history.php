<?php
require "vendor/autoload.php";

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

$pdf->setFontSubsetting(true);
$pdf->SetFont('dejavusans', '', 15, '', true);
$pdf->SetMargins(10, 70, 10, true);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->AddPage();
$pdf->setJPEGQuality(75);
// get the current page break margin
$bMargin = $pdf->getBreakMargin();
// get current auto-page-break mode
$auto_page_break = $pdf->getAutoPageBreak();
// disable auto-page-break
$pdf->SetAutoPageBreak(false, 0);
// restore auto-page-break status
$img_file = K_PATH_IMAGES.'auf-logo.jpg';
$pdf->Image($img_file, 85, 10, 35, 49, '', '', '', false, 300, '', false, false, 0, false, false, false);
$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
// set the starting point for the page content
$pdf->setPageMark();

// Set some content to print
$html = <<<EOD
<h3 style="text-align:center; font-size:20;">History of AUF</h3>
<br><p style="text-align: justify;text-indent: 50px;">Angeles University Foundation, a non-stock, non-profit educational institution, was established on May 25, 1962 by Mr. Agustin P. Angeles, Dr. Barbara Y. Angeles, and family. In less than nine years, the Institution was granted University status on April 16, 1971 by the Department of Education, Culture and Sports.</p>
<br><p style="text-align: justify;text-indent: 50px;">On December 4, 1975, the University was converted to a non-stock, non-profit educational foundation -- the Angeles couple and their children executed a Deed of Donation relinquishing their ownership. AUF was incorporated under Republic Act No. 6055, otherwise known as the Foundation Law, and became a tax-exempt institution approved by the Philippine government. All donations and bequests given to the AUF are tax deductible.</p>
<br><p style="text-align: justify;text-indent: 50px;">On February 14, 1978, AUF was converted to a Catholic University. As the first Catholic university in Central Luzon, AUF ensures not only professional success but total development which is anchored on Christian education that is holistic, integrated and formative. On February 20, 1990, the five-storey, 125-bed AUF Medical Center was inaugurated which now serves as a private teaching, training and research hospital, the first ever in Central Luzon.</p>
EOD;

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

$pdf->Output('history.pdf', 'I');