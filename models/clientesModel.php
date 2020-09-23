<?php

namespace models;

use config\helper as help;
use config\conexion;

class clientesModel
{
    /**
     * Obtiene La lista de clientes
     */
    public static function getClientes()
    {
        $con = new conexion();
        return $con->SQND("SELECT * FROM cliente");
    }
    /**
     * Obtiene el cliente
     */
    public static function getClienteById($id)
    {
        $con = new conexion();
        return $con->SPCALLR("CALL sp_getClienteById(:id)", $id);
    }
    /**
     * Inserta un nuevo cliente
     */
    public static function addNewClient($datos)
    {
        $con = new conexion();
        return $con->SPCALLNR("CALL sp_addNewClient(:nombre,:cedula, :telefono, :direccion, :email, :id)", $datos);
    }
    /**
     * actualiza un cliente
     */
    public static function updateClienteById($datos)
    {
        $con = new conexion();
        return $con->SPCALLNR("CALL sp_updateClienteById(:nombre, :cedula, :telefono, :direccion, :email, :id, :idcliente)", $datos);
    }
    /**
     * obtiene todos los productos segun el resultado
     *
     * @return void
     */
    public static function searchClient($data, $nowPage)
    {
        $con = new conexion();
        $totalRows = $con->SQR_ONEROW("SELECT COUNT(c.idcliente) AS cantidad FROM cliente AS c WHERE c.nombre LIKE '%$data%' OR c.cedula LIKE '%$data%' AND c.estado = 1");
        $totalRows = $totalRows['data']['cantidad'];
        $paginacion = help::paginacion($totalRows, 4, $nowPage);
        $init = $paginacion['InitLimit'];
        $result = $con->SPCALL("CALL sp_searchClient('%$data%',$init ,4)");

        if ($result['error'] == '00000'  &&  $result['rows'] > 0) {
            return array("data" =>  $result['data'], "rows" => $result['rows'], "cantidad" => $totalRows, "paginacion" => $paginacion, "nextpage" => (int) $nowPage + 1, "previouspage" => (int) $nowPage - 1, "error" => 0, "msg" => "Se encontro resultado");
        } else if ($result['error'] !== '00000' || $result['data'] == false) {
            return array("data" =>  $result['data'], "rows" => $result['rows'], "cantidad" => $totalRows, "paginacion" => 0, "error" => 1,   "errorData" => $result, "msg" => "No se encontro el Producto disponible o no existe");
        }
    }
}
