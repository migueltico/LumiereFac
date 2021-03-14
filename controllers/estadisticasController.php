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
use models\estadisticasModel as estadisticas;

class estadisticasController extends view

{
    public function getMoreSalesPerMonth()
    {
        $result = estadisticas::getMoreSalesPerMonth();

        $rows = $result['data'];
        $columnsName=[];
        $Cantidad=[];
        foreach ($rows as $key => $value) {
            array_push($columnsName,strtoupper($value['descripcion']." - COD:".$value['codigo']));
            array_push($Cantidad,$value['cantidad_Total']);
        }
        $json['columns'] =$columnsName;
        $json['cantidad'] =$Cantidad;
        header('Content-Type: application/json');
        echo json_encode($json);
    }
    public function getLastWeekSales()
    {
        $result = estadisticas::getLastWeekSales();
        $dias =["Lunes","Martes","Miercoles","Jueves","Viernes","Sabado","Domingo"];
        $rows = $result['data'];
        $columnsName=[];
        $Cantidad=[];
        foreach ($rows as $key => $value) {
            array_push($Cantidad,$value['cantidad']);
        }
        $json['columns'] =$dias;
        $json['cantidad'] =$Cantidad;
        header('Content-Type: application/json');
        echo json_encode($json);
    }
}
