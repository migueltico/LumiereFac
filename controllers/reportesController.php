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
use models\reportesModel as reports;

class reportesController extends view

{
  public function index()
  {
      $icon = help::icon();
      $data["icons"] =  $icon['icons'];
      echo view::renderElement('facturacion/facturacionReportes', $data);
  }
  public function rxCajas()
  {
    $dateInit = $_POST['dateInit'];
    $dateEnd = $_POST['dateEnd'];
    $datos = reports::rxfacDia($dateInit, $dateEnd);
    $data["rowsDiarios"] = $datos['data'];
    echo view::renderElement('reportes/Rxtipo/ReporteFacturasPorDia', $data);
  }
  public function rxfacDia()
  {
    $icon = help::icon();
    $data["icons"] =  $icon['icons'];
    $dateInit = $_POST['dateInit'];
    $dateEnd = $_POST['dateEnd'];
    $datos = reports::rxfacDia($dateInit, $dateEnd);
    $data["rowsDiarios"] = $datos['data'];
    echo view::renderElement('reportes/Rxtipo/ReporteFacturasPorDia/ReporteFacturasPorDia', $data);
  }
  public function rxfacDiaDetalle()
  {
    $icon = help::icon();
    $data["icons"] =  $icon['icons'];
    $dateInit = $_POST['dateInit'];
    $dateEnd = $_POST['dateEnd'];
    $datos = reports::rxfacDiaDetalle($dateInit, $dateEnd);
    $data["rowsDetalles"] = $datos['data'];
    $fechasArray = [];
    $rowPerDate = [];
    foreach ($data["rowsDetalles"] as $row) {

      array_push($fechasArray, $row["fecha"]);
    }
    $fechasArray = array_unique($fechasArray);
    asort($fechasArray);
    foreach ($fechasArray as $key => $fecha) {
      foreach ($data["rowsDetalles"] as $row) {
        if ($row["fecha"] == $fecha) {
          if (isset($rowPerDate[$fecha])) {
            array_push($rowPerDate[$fecha]['rows'], $row);
          } else {
            $rowPerDate[$fecha]['rows'] = [];
            $rowPerDate[$fecha]['fecha'] = $fecha;
            $rowPerDate[$fecha]['caja'] = $row['caja'];
            array_push($rowPerDate[$fecha]['rows'], $row);
          }
        }
      }
    }
    $data['data'] = $rowPerDate;
    echo view::renderElement('reportes/Rxtipo/ReporteFacturasPorDiaDetalle/ReporteFacturasPorDiaDetalle', $data);
  }
  public function rxfacDiaDetallePDF()
  {
    $dateInit = $_POST['dateInit'];
    $dateEnd = $_POST['dateEnd'];
    $datos = reports::rxfacDiaDetalle($dateInit, $dateEnd);
    $data["rowsDetalles"] = $datos['data'];
    $fechasArray = [];
    $rowPerDate = [];
    foreach ($data["rowsDetalles"] as $row) {

      array_push($fechasArray, $row["fecha"]);
    }
    $fechasArray = array_unique($fechasArray);
    asort($fechasArray);
    foreach ($fechasArray as $key => $fecha) {
      foreach ($data["rowsDetalles"] as $row) {
        if ($row["fecha"] == $fecha) {
          if (isset($rowPerDate[$fecha])) {
            array_push($rowPerDate[$fecha]['rows'], $row);
          } else {
            $rowPerDate[$fecha]['rows'] = [];
            $rowPerDate[$fecha]['fecha'] = $fecha;
            $rowPerDate[$fecha]['caja'] = $row['caja'];
            array_push($rowPerDate[$fecha]['rows'], $row);
          }
        }
      }
    }
    $data['data'] = $rowPerDate;
    return view::renderElement('reportes/Rxtipo/ReporteFacturasPorDiaDetalle/ReporteFacturasPorDiaDetallePDF', $data);
  }
  public function rxfacDiaPDF()
  {
    $dateInit = $_POST['dateInit'];
    $dateEnd = $_POST['dateEnd'];
    $datos = reports::rxfacDia($dateInit, $dateEnd);
    $data["rowsDiarios"] = $datos['data'];
    return view::renderElement('reportes/Rxtipo/ReporteFacturasPorDia/ReporteFacturasPorDiaPDF', $data);
  }
  public function rxFacturasXCliente()
  {
    $icon = help::icon();
    $data["icons"] =  $icon['icons'];
    $dateInit = $_POST['dateInit'];
    $dateEnd = $_POST['dateEnd'];
    $datos = reports::rxFacturasXCliente($dateInit, $dateEnd);
    $data["ventasRows"] = $datos['data'];
    return view::renderElement('reportes/Rxtipo/RxFacturasXCliente/rxFacturasXCliente', $data);
  }
  public function rxFacturasXClientePDF()
  {
    $dateInit = $_POST['dateInit'];
    $dateEnd = $_POST['dateEnd'];
    $datos = reports::rxFacturasXCliente($dateInit, $dateEnd);
    $data["ventasRows"] = $datos['data'];
    return view::renderElement('reportes/Rxtipo/RxFacturasXCliente/rxFacturasXClientePDF', $data);
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

  //
  //**************ETIQUETAS********************** */
  //
  public function Rxtipo()
  {
    $data = json_decode(file_get_contents("php://input"), true);
    $datos['items'] = $data;
    //print_r($data);
    echo view::renderElement('reportes/Etiquetas/etiquetasTallaEstilo', $datos);
  }
  public function etiquetasTallaEstilo()
  {
    ob_start();
    $data = json_decode(file_get_contents("php://input"), true);
    $datos['items'] = $data;
    //print_r($data);
    echo view::renderElement('reportes/Etiquetas/etiquetasTallaEstilo', $datos);
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
    echo view::renderElement('reportes/Etiquetas/etiquetasTallaEstilo', $datos);
  }
}
