<?php

namespace App\Services;

use App\Interfaces\IPdfService;

use VerumConsilium\Browsershot\Facades\PDF;

class PdfService implements IPdfService
{
    public function streamPdf(string $bladeView, string $bladeFooter, array $data, string $pdfName)
    {
        return PDF::loadView($bladeView, $data)
            ->noSandBox()
            ->waitUntilNetworkIdle()
            ->setDelay(500)
            ->showBrowserHeaderAndFooter()
            ->showBackground()
            ->format('A4')
            ->margins(0, 0, 20, 0)
            ->hideHeader()
            ->footerHtml(view($bladeFooter)->render())
            ->inline($pdfName . '.pdf');
    }
}
