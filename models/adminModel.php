<?php

namespace models;

use config\helper as h;
use config\conexion;

class adminModel
{
    /**
     * Obtiene el usuario que coincida con los datos proporcionados
     *
     * @param string $user
     * @param string $pass
     * @return void
     */
    public static function getGastos()
    {
        $con = new conexion();
        return $con->SQR_ONEROW('
        SELECT g.gastos, g.total, g.efectivo, g.tarjeta, g.transferencia, g.modificado_por, DATE_FORMAT(g.fecha_ingresos,"%m-%Y") AS mes, u.nombre, u.usuario, g.modificado_el AS fecha
        FROM gastos AS g
        INNER JOIN usuario AS u ON u.idusuario = g.modificado_por
        WHERE g.idgastos=1');
    }
    public static function  infoSucursal()
    {
        $con = new conexion();
        return $con->SQR_ONEROW('SELECT * FROM generalinfo WHERE idgeneral = 1');
    }

    public static function setGastos($datos)
    {
        $con = new conexion();
        return $con->SQ('CALL sp_addGastos(:gastos,:total,:iduser)', $datos);
    }
    public static function addGeneralInfo($datos)
    {
        $params = h::coverToSqlparams($datos);
        $con = new conexion();
        return $con->SQ("CALL sp_addGeneralInfo($params)", $datos);
    }
    public static function addnewDescuento($datos)
    {
        $con = new conexion();
        return $con->SQ("INSERT INTO descuentos (descripcion, descuento, showFac, creado_por, modificado_por, activo) VALUE (:descripcion, :descuento, :show, :creado_por, :modificado_por, :activo)", $datos);
    }
    public static function updateDescuento($datos)
    {
        $con = new conexion();
        return $con->SQ("UPDATE descuentos SET descripcion = :descripcion, descuento = :descuento, showFac = :show, modificado_por =:modificado_por, activo = :activo WHERE iddescuento = :id", $datos);
    }
    public static function aplicarDescuentoEnLote($datos)
    {
        $con = new conexion();
        $codigos = explode(",", $datos[':codigos']);
        $iddescuento =  $datos[':iddescuento'];
        $ok = true;
        foreach ($codigos as $codigo) {
            $codigo = (int) $codigo;
            $array[':codigo'] = $codigo;
            $array[':iddescuento'] = (int) $iddescuento;

            $result = $con->SQNDNR("UPDATE producto SET iddescuento = $iddescuento WHERE codigo=$codigo");
            if ($result['error'] !== '00000') {
                $ok = false;
            }
        }
        if ($ok) {
            return ["error" => '00000'];
        } else {
            return ["error" => 'fatal'];
        }
    }
    public static function getGeneralInfo()
    {
        $con = new conexion();
        return $con->SQR_ONEROW("CALL getGeneralInfo()");
    }
    public static function descuentos()
    {
        $con = new conexion();
        return $con->SPCALL("SELECT * FROM descuentos");
    }
    public static function getproduct($codigo)
    {
        $con = new conexion();
        $result = $con->SQR_ONEROW("CALL sp_searchCodeProduct('$codigo')");

        if ($result['error'] == '00000'  &&  $result['rows'] > 0) {
            return array("data" =>  $result['data'], "rows" => $result['rows'], "error" => 0, "msg" => "Se encontro resultado");
        } else if ($result['error'] !== '00000' || $result['data'] == false) {
            return array("data" =>  $result['data'], "rows" => $result['rows'], "error" => 1,   "errorData" => $result, "msg" => "No se encontro el Producto disponible o no existe");
        }
    }
    public static function addoferta($datos)
    {
        $con = new conexion();
        return $con->SQ('INSERT INTO ofertas (nombreOferta, cantidad, productoOrlista, descuento, unica, productos) VALUES	(:nombreOferta, :cantidad, :productoOrlista, :descuento, :unica, :productos)', $datos);
    }
    public static function updateOferta($datos)
    {
        $con = new conexion();
        return $con->SQ('UPDATE ofertas SET nombreOferta=:nombreOferta, cantidad=:cantidad, productoOrlista=:productoOrlista, descuento=:descuento, unica=:unica, productos=:productos WHERE idOferta = :id', $datos);
    }
    public static function deleteOferta($id)
    {
        $con = new conexion();
        return $con->SQNDNR("DELETE FROM ofertas WHERE idOferta = $id");
    }
    public static function getOfertasById($id)
    {
        $con = new conexion();
        return $con->SQR_ONEROW("SELECT * FROM ofertas WHERE idOferta = $id");
    }
    public static function getAllOfertas()
    {
        $con = new conexion();
        return $con->SPCALL("SELECT * FROM ofertas");
    }
    public static function getAllTiendas()
    {
        $data =[];
        foreach ($GLOBALS["DB_NAME"] as $key => $db) {
            $con = new conexion($db);
            $dataSp = $con->SQR_ONEROW("SELECT nombre_local FROM generalinfo");
            $data[$db] = $dataSp['data']['nombre_local'];
        }
        return $data;
    }
    public static function descuentosOnlyFac()
    {
        $con = new conexion();
        return $con->SPCALL("SELECT * FROM descuentos WHERE showFac=1");
    }
    public static function getCategoriaPrecios()
    {
        $con = new conexion();
        return $con->SPCALL('CALL sp_getCategoriaPrecios()');
    }
    public static function AddCategoriaPrecios($datos)
    {
        $con = new conexion();
        return $con->SQ('CALL sp_addCategoriasPrecios(:descripcion,:factor,:iduser)', $datos);
    }
    public static function AddCategoria($datos)
    {
        $con = new conexion();
        return $con->SQ('CALL sp_addCategorias(:categoria)', $datos);
    }
    public static function AddTalla($datos)
    {
        $con = new conexion();
        return $con->SQ('CALL sp_addTallas(:descripcion,:talla)', $datos);
    }
    public static function getCategorias()
    {
        $con = new conexion();
        return $con->SPCALL('CALL sp_getCategorias()');
    }
    public static function getTallas()
    {
        $con = new conexion();
        return $con->SPCALL('CALL sp_getTallas()');
    }

    public static function editTallas($datos)
    {
        $con = new conexion();
        return $con->SQ('CALL sp_updateTalla(:descripcion,:talla,:id)', $datos);
    }
    public static function editCategorias($datos)
    {
        $con = new conexion();
        return $con->SQ('CALL sp_updateCategoria(:categoria,:id)', $datos);
    }
    public static function EditCategoriaPrecios($datos)
    {
        $con = new conexion();
        return $con->SQ('CALL sp_EditCategoriasPrecios(:descripcion,:factor,:iduser,:id)', $datos);
    }
    public static function DeleteCategoriaPrecios($datos)
    {
        $con = new conexion();
        return $con->SQ('DELETE FROM categoria_precios WHERE idCategoriaPrecio = :id', $datos);
    }
    /**
     * Guarda la accion generada por el usuario
     *
     * @param string $accion Generada
     * @param string $modulo Modulo donde se genero la accion
     * @param string $detalle Detalle de la accion
     * @param string $datos Datos en formato json
     * @param string $idusuario Usuario
     * @return void
     */
    public static function saveLog($accion, $modulo, $detalle, $datos, $idusuario)
    {
        $con = new conexion();
        $datos = array(
            ':accion' => $accion,
            ':modulo' => $modulo,
            ':detalle' => $detalle,
            ':datos' => $datos,
            ':idusuario' => $idusuario
        );
        return $con->SQ('INSERT INTO log (accion, modulo, detalle, datos, idusuario) VALUES	(:accion,:modulo,:detalle,:datos,:idusuario)', $datos);
    }
}
