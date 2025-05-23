<?php

namespace App\Http\Controllers;

use App\Models\Personal;
use QrCode;
use Illuminate\Http\Request;
use PDF;
use Alert;
class PdfController extends Controller
{
    public function pdfPersonal($id)
    {
        $personal = Personal::find($id);
        if (!$personal) {
            Alert::error('¡Error!', 'Personal no encontrado.')->showConfirmButton('Aceptar', 'rgb(5, 68, 141)');

        }
        $valorQr = QrCode::size(70)->generate($personal->qr_code);
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadView('personal.pdf', compact('personal', 'valorQr'));
        return $pdf->stream('personal.pdf');
    }

    public function pdfReportePersonal($id){
         $personal = Personal::find($id);
        if (!$personal) {
            Alert::error('¡Error!', 'Personal no encontrado.')->showConfirmButton('Aceptar', 'rgb(5, 68, 141)');

        }
        $pdf = \App::make( 'dompdf.wrapper');
        $pdf->loadView('personal.reporte', compact('personal'));
        return $pdf->stream('reporte.pdf');
    }
}
