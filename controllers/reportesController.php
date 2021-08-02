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

//excel
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

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
    //asort($fechasArray);
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
  public function rxfacDiaDetalleExcel()
  {
    $spreadsheet = new Spreadsheet();

    // Set document properties
    $spreadsheet->getProperties()->setCreator("TEST")
      ->setLastModifiedBy('Maarten Balliauw')
      ->setTitle('Reporte de Facturas Diarias Detallada')
      ->setSubject('Reporte de Facturas Diarias Detallada')
      ->setDescription('Reporte de Facturas Diarias Detallada')
      ->setKeywords('Reporte ,Facturas,Detallada')
      ->setCategory('Reporte');

    // Add some data


    //$dateInit = "2021-06-16";
    //$dateEnd = "2021-06-18";
    $dateInit = $_GET['dateInit'];
    $dateEnd = $_GET['dateEnd'];
    $datos = reports::rxfacDiaDetalle($dateInit, $dateEnd);
    $data["rowsDetalles"] = $datos['data'];
    $fechasArray = [];
    $rowPerDate = [];
    // var_dump($datos);exit;
    foreach ($data["rowsDetalles"] as $row) {

      array_push($fechasArray, $row["fecha"]);
    }
    $fechasArray = array_unique($fechasArray);
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



    $row = 1;

    //TITULO
    $spreadsheet->getActiveSheet()->setCellValue('A' . $row, "Caja");
    $spreadsheet->getActiveSheet()->setCellValue('B' . $row, "Fecha");
    $spreadsheet->getActiveSheet()->setCellValue('C' . $row, "#Doc");
    $spreadsheet->getActiveSheet()->setCellValue('D' . $row, "Tipo Doc");
    $spreadsheet->getActiveSheet()->setCellValue('E' . $row, "Tipo Venta");
    $spreadsheet->getActiveSheet()->setCellValue('F' . $row, "#Fac Ref");
    $spreadsheet->getActiveSheet()->setCellValue('G' . $row, "Monto Efectivo");
    $spreadsheet->getActiveSheet()->setCellValue('H' . $row, "Monto Tarjeta");
    $spreadsheet->getActiveSheet()->setCellValue('I' . $row, "#Tarjetas");
    $spreadsheet->getActiveSheet()->setCellValue('J' . $row, "Monto Transferencia");
    $spreadsheet->getActiveSheet()->setCellValue('K' . $row, "Banco");
    $spreadsheet->getActiveSheet()->setCellValue('L' . $row, "#Transf");
    $spreadsheet->getActiveSheet()->setCellValue('M' . $row, "Descuento");
    $spreadsheet->getActiveSheet()->setCellValue('N' . $row, "Impuesto");
    $spreadsheet->getActiveSheet()->setCellValue('O' . $row, "Total");

    //STYLES
    $spreadsheet->getActiveSheet()->getStyle('A' . $row . ":" . 'O' . $row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('AAAAAA');
    $spreadsheet->getActiveSheet()->getStyle('A:O')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    foreach (range('A', 'O') as $col) {
      $spreadsheet->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
    }
    $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(10);
    $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(15);
    $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(15);
    $spreadsheet->getActiveSheet()->getColumnDimension('O')->setWidth(15);

    $row++;
    foreach ($rowPerDate as $fecha => $data) {
      foreach ($data['rows'] as $rows) {
        $extra_tarjetas = $rows['n_tarjeta'];
        if ($rows["n_tarjeta_multi"] != "" || $rows["n_tarjeta_multi"] != null) {
          $tarjetas_varias = explode(";", $rows["n_tarjeta_multi"]);
          foreach ($tarjetas_varias as $tarjeta) {
            $tarjeta = explode(",", $tarjeta);
            $extra_tarjetas .= ", " . $tarjeta[0];
          }
        }

        //CELLS VALUE
        $spreadsheet->getActiveSheet()->setCellValue('A' . $row, $rows['caja']);
        $spreadsheet->getActiveSheet()->setCellValue('B' . $row, $rows['fecha']);
        $spreadsheet->getActiveSheet()->setCellValue('C' . $row, $rows['docNum']);
        $spreadsheet->getActiveSheet()->setCellValue('D' . $row, $rows['doc']);
        $spreadsheet->getActiveSheet()->setCellValue('E' . $row, $rows['tipoDoc']);
        $spreadsheet->getActiveSheet()->setCellValue('F' . $row, $rows['docRef'] ?? "N/A");
        $spreadsheet->getActiveSheet()->setCellValue('G' . $row, $rows['efectivo']);
        $spreadsheet->getActiveSheet()->setCellValue('H' . $row, $rows['tarjeta']);
        $spreadsheet->getActiveSheet()->setCellValue('I' . $row, trim($extra_tarjetas) ?? "N/A");
        $spreadsheet->getActiveSheet()->setCellValue('J' . $row, $rows['transferencia']);
        $spreadsheet->getActiveSheet()->setCellValue('K' . $row, trim($rows['banco']) ?? "N/A");
        $spreadsheet->getActiveSheet()->setCellValue('L' . $row, trim($rows['referencia_t']) ?? "N/A");
        $spreadsheet->getActiveSheet()->setCellValue('M' . $row, $rows['descuento']);
        $spreadsheet->getActiveSheet()->setCellValue('N' . $row, $rows['impuesto']);
        $spreadsheet->getActiveSheet()->setCellValue('O' . $row, $rows['total']);


        //STYLES CELLS
        $spreadsheet->getActiveSheet()->getStyle('A' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('B' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

        $spreadsheet->getActiveSheet()->getStyle('G' . $row)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
        $spreadsheet->getActiveSheet()->getStyle('H' . $row)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
        $spreadsheet->getActiveSheet()->getStyle('J' . $row)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
        $spreadsheet->getActiveSheet()->getStyle('M' . $row)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
        $spreadsheet->getActiveSheet()->getStyle('N' . $row)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
        $spreadsheet->getActiveSheet()->getStyle('O' . $row)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

        $spreadsheet->getActiveSheet()->getStyle('G' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $spreadsheet->getActiveSheet()->getStyle('H' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $spreadsheet->getActiveSheet()->getStyle('J' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $spreadsheet->getActiveSheet()->getStyle('M' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $spreadsheet->getActiveSheet()->getStyle('N' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $spreadsheet->getActiveSheet()->getStyle('O' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);


        $row++;
      }
    }
    //var_dump( $rowPerDate);exit;
    // Rename worksheet
    $spreadsheet->getActiveSheet()->setTitle('Facturas Diarias Detallada');

    // Set active sheet index to the first sheet, so Excel opens this as the first sheet
    $spreadsheet->setActiveSheetIndex(0);

    // Redirect output to a client’s web browser (Xlsx)
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Facturas_Diarias_Detallada.xlsx"');
    header('Cache-Control: max-age=0');

    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    $writer->save('php://output');
    exit;
  }


  public function rxfacDiaDetalleMetodoPago()
  {
    $icon = help::icon();
    $data["icons"] =  $icon['icons'];
    $dateInit = $_POST['dateInit'];
    $dateEnd = $_POST['dateEnd'];
    $metodo = $_POST['metodo'];
    $datos = reports::rxfacDiaDetalleMetodoPago($dateInit, $dateEnd, $metodo);
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
    echo view::renderElement('reportes/Rxtipo/ReporteFacturasDetalladasPorMetodoPago/ReporteFacturasDetalladasPorMetodoPago', $data);
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
  public function rxfacDiaDetalleMetodoPagoPDF()
  {
    $dateInit = $_POST['dateInit'];
    $dateEnd = $_POST['dateEnd'];
    $metodo = $_POST['metodo'];
    $datos = reports::rxfacDiaDetalleMetodoPago($dateInit, $dateEnd, $metodo);
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
    return view::renderElement('reportes/Rxtipo/ReporteFacturasDetalladasPorMetodoPago/ReporteFacturasDetalladasPorMetodoPagoPDF', $data);
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
    echo view::renderElement('reportes/Rxtipo/Etiquetas/etiquetasTallaEstilo', $datos);
  }
  public function etiquetasTallaEstilo()
  {
    ob_start();
    $data = json_decode(file_get_contents("php://input"), true);
    $datos['items'] = $data;
    //print_r($data);
    echo view::renderElement('reportes/Rxtipo/Etiquetas/etiquetasTallaEstilo', $datos);
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
    echo view::renderElement('reportes/Rxtipo/Etiquetas/etiquetasTallaEstilo', $datos);
  }
}
