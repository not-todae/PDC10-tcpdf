<?php
require "vendor/autoload.php";

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

class MC_TCPDF extends TCPDF {
    
    function Header()
    {
        global $title;
    
        // Times bold 15
        $this->SetFont('Times','B',15);
        // Calculate width of title and position
        $w = $this->GetStringWidth($title)+6;
        $this->SetX((210-$w)/2);
        // Colors of frame, background and text
        $this->SetDrawColor(0,80,180);
        $this->SetFillColor(230,230,0);
        $this->SetTextColor(220,50,50);
        // Thickness of frame (1 mm)
        $this->SetLineWidth(1);
        // Title
        $this->Cell($w,9,$title,1,1,'C',true);
        // Line break
        $this->Ln(10);
    }
    
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Times italic 8
        $this->SetFont('Times','I',8);
        // Text color in gray
        $this->SetTextColor(128);
        // Page number
        $this->Cell(0,10,'Page '.$this->PageNo(),0,0,'C');
    }
    
    function ChapterTitle($num, $label)
    {
        // Times 12
        $this->SetFont('Times','',12);
        // Background color
        $this->SetTextColor(255,255,6);
        $this->SetFillColor(200,220,255);
        // Title
        $this->Cell(0,6,"Chapter $num : $label",0,1,'L',true);
        // Line break
        $this->Ln(4);
    }
    
    function ChapterBody($file)
    {
        // Read text file
        $txt = file_get_contents($file);
        // Times 12
        $this->SetFont('Times','',12);
        $this->SetTextColor(0,0,0);
        // Output justified text
        $this->MultiCell(0,5,$txt);
        // Line break
        $this->Ln();
        // Mention in italics
        $this->SetFont('','I');
        $this->Cell(0,5,'(end of excerpt)');
    }
    
    function PrintChapter($num, $title, $file)
    {
        $this->SetFillColor(212,55,55);
        $this->AddPage();
        $this->ChapterTitle($num,$title);
        $this->ChapterBody($file);
    }
    }
    
    $pdf = new MC_TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $title = 'Star Wars - Dark Force Rising';
    $pdf->SetTitle($title);
    $pdf->SetAuthor('Timothy Zahn');
    $pdf->PrintChapter(1,' Heir to the Empire','CHAPTER 1.txt');
    $pdf->PrintChapter(2,' Dark Force Rising','CHAPTER 2.txt');
    $pdf->PrintChapter(3,' The Last Command','CHAPTER 3.txt');
    $pdf->Output('example_001.pdf', 'I');
    ?>