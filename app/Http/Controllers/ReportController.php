<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Report;
use Barryvdh\DomPDF\Facade as PDF;

class ReportController extends Controller
{
    public function reporteaplicaciones()
    {
        Report::reporteaplicaciones($_POST['cedula']);
        $pdf = PDF::loadView('Reportes/reporteAplicaciones');
        return $pdf->stream('MisAplicaciones.pdf');
    }

    public function reporteempresa(){
        Report::reporteempresa($_POST['empresa']);
        $pdf = PDF::loadView('Reportes/reporteEmpresa');
        return $pdf->stream('Empresa.pdf');
    }

    public function reportecurriculum(){
        Report::reportecurriculum($_POST['cedula']);
        $pdf = PDF::loadView('Reportes/reporteCurriculum');
        return $pdf->stream('ReporteCurriculum_'.$_POST['cedula'].'.pdf');
    }

    public function reporteporcategoria(){
        Report::reporteporcategoria();
        $pdf = PDF::loadView('Reportes/reportePorCategoria');
        return $pdf->stream('ReportePorCategoria.pdf');
    }

    public function index(){
        echo 'holi';
    }
}
