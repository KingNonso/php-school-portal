<?php

    include('public/TCPDF-master/tcpdf.php');

    class MYPDF extends TCPDF {

        private $header;


        //Page header
        public function Header() {

            $html = Session::get('academic_class_name').' '.Session::get('academic_session_name').' -  Annual ';
            $this->SetFillColor(255,255,0);
            // Set font
            $this->SetFont('helvetica', 'B', 20);
            // Title
            $this->Cell(0, 15, $html, 0, false, 'C', 0, '', 0, false, 'M', 'M');
            //$this->writeHTML($html, true, false, false, false, '');
        }

        // Page footer
        public function Footer() {
            // Position at 15 mm from bottom
            $this->SetY(-15);
            // Set font
            $this->SetFont('helvetica', 'I', 8);
            // Page number
            $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
        }
    }