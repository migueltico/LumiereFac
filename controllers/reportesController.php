<?php

namespace controllers;
// manda a llamar al controlador de vistas
use config\view;
// manda a llamar al controlador de conexiones a bases de datos
use models\usuariosModel as users;
use Dompdf\Dompdf;
use Dompdf\Options;
//Funciones de ayuda
use config\helper as help;
// la clase debe llamarse igual que el controlador respetando mayusculas
class reportesController extends view

{

    public function etiquetasTallaEstilo()
    {
        ob_start();
        $data = json_decode(file_get_contents("php://input"), true);
        $datos['items'] = $data;
        //print_r($data);
        echo view::renderElement('reportes/etiquetasTallaEstilo', $datos);
        $dompdf = new Dompdf();
        $dompdf->loadHtml(ob_get_clean());
        // (Optional) Setup the paper size and orientation
        $dompdf->render();
        $pdf = $dompdf->output();
        $filename = "Etiquetas";
        file_put_contents($filename, $pdf);
        // Output the generated PDF to Browser
        $dompdf->stream($filename);
    }
    public function etiquetasTallaEstiloPost()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $datos['items'] = $data;
        //print_r($data);
        echo view::renderElement('reportes/etiquetasTallaEstilo', $datos);
    }
    public function ReportesFacturacion()
    {
        $reporte = $_POST['tipoReporte'];
        switch ($reporte) {
            case 1:
                return false;
              break;
            case 2:
                return true;
              break;
            case 3:
                return false;
              break;
            case 4:
                return false;
              break;
            case 5:
                return false;
              break;
            case 6:
                return false;
              break;
            default:
            return false;
          }
    }
    public function Rxtipo()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $datos['items'] = $data;
        //print_r($data);
        echo view::renderElement('reportes/etiquetasTallaEstilo', $datos);
    }
}

