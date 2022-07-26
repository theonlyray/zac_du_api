<?php

namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller{

  public function pdf_solicitud($tipo){
    $pdf = PDF::loadView('solicitudes.basic_solicitud');
    return $pdf->stream();
  }

  public function pdf_licencia($tipo){
    $pdf = PDF::loadView('licencias.basic_licencia');
    return $pdf->stream();
  }

}
