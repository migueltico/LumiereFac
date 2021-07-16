<?php

namespace models;

use config\helper as h;
use config\conexion;
use config\helper;

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
            'INSERT INTO producto (descripcion,descripcion_short,marca,estilo,idcategoria,idtalla,codigo,iva,activado_iva,creado_por,modificado_por,image_url,estado,categoriaPrecio)
            VALUES (:descripcion,:descripcion_short,:marca,:estilo,:categoria,:talla,:codigoBarras,:iva_valor,:iva,:idusuario,:idusuario,:urls,:estado,:categoriaPrecio)',
            $datos
        );
        if ($mainProduct['error'] == '00000') {
            return array("data" => null, "error" => 0, "msg" => "Registros ingresados correctamente", $mainProduct);
        } else {
            return array("data" => null, "error" => 1,   "errorData" => $mainProduct, "msg" => "Error al Registras los datos");
        }
    }
    /**
     * obtiene todas las categorias
     *
     * @return void
     */
    public static function getDescuentos()
    {
        $con = new conexion();

        return $con->SQND('SELECT * FROM descuentos');
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
    public static function searchCodeProduct($data)
    {
        $con = new conexion();
        $result = $con->SQR_ONEROW("CALL sp_searchCodeProduct('$data')");

        if ($result['error'] == '00000'  &&  $result['rows'] > 0) {
            return array("data" =>  $result['data'], "rows" => $result['rows'], "error" => 0, "msg" => "Se encontro resultado");
        } else if ($result['error'] !== '00000' || $result['data'] == false) {
            return array("data" =>  $result['data'], "rows" => $result['rows'], "error" => 1,   "errorData" => $result, "msg" => "No se encontro el Producto disponible o no existe");
        }
    }
    /**
     * obtiene todos los productos segun el resultado
     *
     * @return void
     */
    public static function searchCodeProductCtrlQ($data, $nowPage)
    {
        try {
            $con = new conexion();
            $cantToshow = 50;
            $totalRows = $con->SQR_ONEROW("SELECT COUNT(p.idproducto) AS cantidad FROM producto AS p WHERE p.descripcion LIKE '%$data%' OR p.marca LIKE '%$data%' AND p.estado = 1");
            $totalRows = $totalRows['data']['cantidad'];
            $paginacion = helper::paginacion($totalRows, $cantToshow, $nowPage);
            $init = $paginacion['InitLimit'];

            if (strpos($data, '%') !== false) {
                $dataArray = explode("%", $data);
                $string = "";
                foreach ($dataArray as $value) {
                    $string .= $value . "%";
                }
                $SqlMultiParam = "CALL sp_searchCodeProductCtrlQ('%$string',$init ,$cantToshow)";
                $result = $con->SPCALL($SqlMultiParam);
            } else {
                $SqlOneParam = "CALL sp_searchCodeProductCtrlQ('%$data%',$init ,$cantToshow)";
                $result = $con->SPCALL($SqlOneParam);
            }

            if ($result['error'] == '00000'  &&  $result['rows'] > 0) {
                return array("data" =>  $result['data'], "rows" => $result['rows'], "cantidad" => $totalRows, "paginacion" => $paginacion, "nextpage" => (int) $nowPage + 1, "previouspage" => (int) $nowPage - 1, "error" => 0, "msg" => "Se encontro resultado");
            } else if ($result['error'] !== '00000' || $result['data'] == false) {
                return array("data" =>  $result['data'], "rows" => $result['rows'], "cantidad" => $totalRows, "paginacion" => 0, "error" => 1,   "errorData" => $result, "msg" => "No se encontro el Producto disponible o no existe");
            }
        } catch (\Throwable $th) {
            return array(
                "data" =>  $result['data'],
                "rows" => $result['rows'], "cantidad" => $totalRows,
                "nowPage" => $nowPage, "paginacion" => 0, "error" => 1,
                "errorData" => $th->getMessage(), "msg" => "No se encontro el Producto disponible o no existe"
            );
        }
    }
    /**
     * obtiene todos los productos segun el resultado
     *
     * @return void
     */
    public static function searchProduct($data, $nowPage, $estado)
    {
        try {
            //code...

            $cantToshow = 100;
            $data = trim($data);
            $con = new conexion();
            $totalRows = $con->SQR_ONEROW("SELECT COUNT(p.idproducto) AS cantidad FROM producto AS p WHERE (p.descripcion LIKE '%$data%' OR p.marca  LIKE '%$data%' OR p.estilo LIKE '%$data%' OR p.codigo LIKE '%$data%') AND p.estado = $estado");
            // $totalRows = $con->SQR_ONEROW("SELECT COUNT(p.idproducto) AS cantidad FROM producto AS p WHERE p.estado = 1");
            // $totalRows = $con->SQR_ONEROW("sp_SearchProduct_Inventario('%$data%')");
            $totalRows = $totalRows['data']['cantidad'];
            $paginacion = helper::paginacion($totalRows, $cantToshow, $nowPage);
            $init = $paginacion['InitLimit'];
            if (strpos($data, '%') !== false) {
                $dataArray = explode("%", $data);
                $string = "";
                foreach ($dataArray as $value) {
                    $string .= $value . "%";
                }
                $SqlMultiParam = "CALL sp_searchCodeProductWithState('%$string',$init ,$cantToshow,$estado )";
                $result = $con->SPCALL($SqlMultiParam);
            } else {
                $SqlOneParam = "CALL sp_searchCodeProductWithState('%$data%',$init ,$cantToshow,$estado )";
                $result = $con->SPCALL($SqlOneParam);
            }
            if ($result['error'] == '00000'  &&  $result['rows'] > 0) {
                return array("data" =>  $result['data'], "rows" => $result['rows'], "cantidad" => $totalRows, "nowPage" => $nowPage, "paginacion" => $paginacion, "nextpage" => (int) $nowPage + 1, "previouspage" => (int) $nowPage - 1, "error" => 0, "msg" => "Se encontro resultado");
            } else if ($result['error'] !== '00000' || $result['data'] == false) {
                return array("data" =>  $result['data'], "rows" => $result['rows'], "cantidad" => $totalRows, "nowPage" => $nowPage, "paginacion" => 0, "error" => 1,   "errorData" => $result, "msg" => "No se encontro el Producto disponible o no existe");
            }
        } catch (\Throwable $th) {
            return array(
                "data" =>  $result['data'],
                "rows" => $result['rows'], "cantidad" => $totalRows,
                "nowPage" => $nowPage, "paginacion" => 0, "error" => 1,
                "errorData" => $th->getMessage(), "msg" => "No se encontro el Producto disponible o no existe"
            );
        }
        // $con = new conexion();
        // if (strpos($data, 'id-') !== false) {
        //     $data = str_replace('id-', '', $data);
        //     $result = $con->SPCALL("CALL sp_searchProductById('$data')");
        // } else {

        //     $result = $con->SPCALL("CALL sp_searchProductLike('%$data%')");
        // }
        // if ($result['error'] == '00000') {
        //     return array("data" =>  $result['data'], "rows" => $result['rows'], "error" => 0, "msg" => "Se encontro resultado");
        // } else if ($result['error'] !== '00000') {
        //     return array("data" =>  $result['data'], "rows" => $result['rows'], "error" => 1,   "errorData" => $result, "msg" => "Error al Cargar los datos");
        // }
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
        $setData = ',,,,,,,,,,,,,,,';
        // $newSql = "CALL sp_updateProduct($setData)";

        $sql = "UPDATE producto AS p
                SET p.descripcion = :descripcion, p.marca = :marca, p.estilo = :estilo, p.idcategoria = :categoria, p.idtalla = :talla,
                p.codigo = :codigoBarras, p.iva = :iva_valor, p.activado_iva = :iva, p.modificado_por = :modificado_por ,p.image_url = :urls, 
                p.estado = :estado, categoriaPrecio = :categoriaPrecio, iddescuento = :descuento, descripcion_short = :descripcion_short, idOferta =:idOferta 
                WHERE p.idproducto = :idproducto";
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
        $id = (int) $datos[':id'];
        $stock = (int)$datos[':stock'];
        $setData = ':id,:stock';

        //obtengo el stock actual
        $sql = "SELECT stock FROM producto WHERE idproducto=$id;";
        $stockNow = $con->SQR_ONEROW($sql);

        //actializo la cantidad al nuevo stock
        $stockNow = (int) $stockNow['data']['stock'];
        $newStock = ($stockNow + $stock);
        $result = $con->SQ("UPDATE producto AS p SET p.stock =:stock WHERE p.idproducto=:id;", array(':id' => $id, ":stock" => $newStock));

        //vuelvo a consultar para comprobar
        $sqlNewStock = "SELECT stock FROM producto WHERE idproducto=$id;";
        $NowNewStock = $con->SQR_ONEROW($sqlNewStock);
        $NowNewStock = $NowNewStock['data']['stock'];
        $result['newStock'] = $NowNewStock;
        return $result;

        // SET @newStock = (SELECT SUM(p.stock + param2) AS total FROM producto AS p WHERE p.idproducto =param1);
        // UPDATE producto AS p SET p.stock =@newStock WHERE p.idproducto=param1;

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
    /**
     * Obtiene el factor por ID del producti
     *
     * @return void
     */
    public static function disableProduct($id, $estado)
    {
        $con = new conexion();
        return $con->SQNDNR("UPDATE producto SET estado = $estado WHERE idproducto=$id");
    }
}
