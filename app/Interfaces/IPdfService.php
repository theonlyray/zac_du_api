<?php

namespace App\Interfaces;

interface IPdfService
{
    /**
     * Stream a generated pdf
     * 
     * @param string $bladeView
     * @param string $bladeFooter
     * @param array $data
     * @param string $pdfName
     */
    public function streamPdf(string $bladeView, string $bladeFooter, array $data, string $pdfName);
}
