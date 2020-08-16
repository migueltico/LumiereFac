<?php

namespace models;

use Config\helper as h;
use config\conexion;

class productModel
{
    /**
     * obtiene todas las categorias
     *
     * @return void
     */
    public static function Addproduct($datos)
    {
        $con = new conexion();
        $mainProduct = $con->SQ(
            'INSERT INTO producto (descripcion,marca,estilo,idcategoria,idtalla,codigo,iva,activado_iva,creado_por,modificado_por,image_url,estado,categoriaPrecio)
            VALUES (:descripcion,:marca,:estilo,:categoria,:talla,:codigoBarras,:iva_valor,:iva,:idusuario,:idusuario,:urls,:estado,:categoriaPrecio)',
            $datos
        );
        if ($mainProduct['error'] == '00000') {
            return array("data" => null, "error" => 0, "msg" => "Registros ingresados correctamente", $mainProduct);
        } else {
            return array("data" => null, "error" => 1,   "errorData" => $mainProduct, "msg" => "Error al Registras los datos");
        }
    }
    /**
     * obtiene todos los productos
     *
     * @return void
     */
    public static function getProducts()
    {
        $con = new conexion();
        return $con->SPCALL("CALL sp_getAllProduct()");
    }
    /**
     * obtiene todos los productos
     *
     * @return void
     */
    public static function getProductById($id)
    {
        $con = new conexion();
        $result = $con->SPCALL("CALL sp_getProductById($id)");
        if ($result['error'] == '00000') {
            return array("data" =>  $result['data'], "rows" => $result['rows'], "error" => 0, "msg" => "Registros cargados correctamente");
        } else if ($result['error'] !== '00000') {
            return array("data" =>  $result['data'], "rows" => $result['rows'], "error" => 1,   "errorData" => $result, "msg" => "Error al Cargar los datos");
        }
    }
    /**
     * obtiene todos los productos segun el resultado
     *
     * @return void
     */
    public static function searchProduct($data)
    {
        $con = new conexion();
        if (strpos($data, 'id-') !== false) {
            $data = str_replace('id-', '', $data);
            $result = $con->SPCALL("CALL sp_searchProductById('$data')");
        } else {

            $result = $con->SPCALL("CALL sp_searchProductLike('%$data%')");
        }
        if ($result['error'] == '00000') {
            return array("data" =>  $result['data'], "rows" => $result['rows'], "error" => 0, "msg" => "Se encontro resultado");
        } else if ($result['error'] !== '00000') {
            return array("data" =>  $result['data'], "rows" => $result['rows'], "error" => 1,   "errorData" => $result, "msg" => "Error al Cargar los datos");
        }
    }
    /**
     * obtiene todos los productos
     *
     * @return void
     */
    public static function getAllProduct()
    {
        $con = new conexion();
        $result = $con->SPCALL("CALL getAllProduct()");
        if ($result['error'] == '00000') {
            return array("data" =>  $result['data'], "rows" => $result['rows'], "error" => 0, "msg" => "Registros cargados correctamente");
        } else if ($result['error'] !== '00000') {
            return array("data" =>  $result['data'], "rows" => $result['rows'], "error" => 1,   "errorData" => $result, "msg" => "Error al Cargar los datos");
        }
    }

    /**
     * obtiene todas las categorias
     *
     * @return void
     */
    public static function getCategory()
    {
        $con = new conexion();

        return $con->SQND('SELECT * FROM categoria');
    }
    /**
     * Obtiene todas las tallas
     *
     * @return void
     */
    public static function getTallas()
    {
        $con = new conexion();

        return $con->SQND('SELECT * FROM tallas');
    }
    /**
     * Actualiza el producto
     *
     * @return void
     */
    public static function updateProduct($datos)
    {
        $con = new conexion();
        $setData = ':descripcion,:marca,:estilo,:categoria,:talla,:codigoBarras,:iva_valor,:iva,:modificado_por,:urls,:estado,:categoriaPrecio,:idproducto';
        $sql = "CALL sp_updateProduct($setData)";
        return $result = $con->SPCALLNR($sql, $datos);
    }
    /**
     * Actualiza los precios del producto
     *
     * @return void
     */
    public static function saveProductPrice($datos)
    {
        $con = new conexion();
        $setData = ':id,:costo,:venta,:unitario,:sugerido';
        $sql = "CALL sp_updatePriceProduct($setData)";
        return $con->SPCALLNR($sql, $datos);
    }
    /**
     * Actualiza el stock 
     *
     * @return void
     */
    public static function updateStock($datos)
    {
        $con = new conexion();
        $setData = ':id,:stock';
        $sql = "CALL sp_updateStockProduct($setData)";
        return $con->SPCALLNR($sql, $datos);
    }
    /**
     * Actualiza el stock Minimo
     *
     * @return void
     */
    public static function updateMinStock($datos)
    {
        $con = new conexion();
        $setData = ':id,:MinStock';
        $sql = "CALL sp_updateMinStockProduct($setData)";
        return $con->SPCALLNR($sql, $datos);
    }
    /**
     * Obtiene el factor por ID del producti
     *
     * @return void
     */
    public static function getFactorProductById($datos)
    {
        $con = new conexion();
        $sql = "CALL sp_getFactorProduct(:id)";
        return $con->SPCALLR($sql, $datos);
    }
}
