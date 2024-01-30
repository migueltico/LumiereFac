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
use models\logsModel as logs;

class logsController extends view

{
    public function index()
    {
        try{
        $icon = help::icon();
        $data["logs"] = logs::getLogs()['data'];
        $data["icons"] =  $icon['icons'];
        $filtros  = logs::getActionsAndModulesFilters();
        $data['acciones'] = $filtros['acciones'];
        $data['modulos'] = $filtros['modulos'];
        echo view::renderElement('logs/logs', $data);
        }catch(\Throwable $th){
            echo $th->getMessage();
        }
    }

    public function getLogs()
    {
        $startDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];
        $modulo = $_POST['modulo'];
        $accion = $_POST['accion'];
        $usuario = $_POST['usuario'];
        $page = 1;
        $perPage = 500;


        $data['logs'] = logs::getLogs($startDate, $endDate, $modulo, $accion, $usuario, $page, $perPage)['data'];
    

        echo view::renderElement('logs/logsTable', $data);
    }
}
