<?php

namespace models;

use config\helper as h;
use config\conexion;
use config\helper;
use models\adminModel as admin;

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
     * Guarda los productos a trasladar
     *
     * @return void
     */
    public static function insertTraslado($dbOrigen, $tiendaTraslado, $productos, $comentarios, $dbTraslado)
    {
        /**
         *  Estados
         * 1: Pendiente
         * 2: Aceptado
         * 3: Cancelado
         * 4: devolucion
         * 5: AceptadaDevolucion
         */
        $tiendaOrigen = $_SESSION['info']['nombre_local'];
        $idUserOrigen = $_SESSION['id'];
        $data = array(
            ":uniqId" => uniqid(rand(100, 1000), true),
            ":tiendaOrigen" => $tiendaOrigen,
            ":tiendaTraslado" => $tiendaTraslado,
            ":dbOrigen" => $dbOrigen,
            ":dbTraslado" => $dbTraslado,
            ":productos" => json_encode($productos),
            ":comentarios" => $comentarios,
            ":idUserOrigen" => $idUserOrigen,
            ":estado" => 1
        );
        $sql = "INSERT INTO traslados 
        (uniqId, tiendaOrigen, tiendaTraslado, dbOrigen, dbTraslado, productos, comentario, idUserOrigen, estado) 
        VALUES(:uniqId, :tiendaOrigen, :tiendaTraslado, :dbOrigen, :dbTraslado, :productos, :comentarios, :idUserOrigen, :estado )";
        $con = new conexion();
        $result = $con->SPCALLNR($sql, $data);
        $error = [];
        $productoModificado = [];
        if ($result['error'] == "00000") {
            foreach ($productos as $producto) {
                $codigo = $producto['codigo'];
                $cantidad = $producto['cantidad'];
                $resultP = $con->SQNDNR("UPDATE producto SET stock = stock - $cantidad WHERE codigo = $codigo");

                if ($resultP['error'] != "00000") {
                    $error["error"] = true;
                    $error[$producto['descripcion']] = $resultP['error'];
                } else {
                    $error["error"] = false;
                    $error[$producto['descripcion']] = true;
                    $productoModificado[$producto['descripcion']] = $cantidad;
                }
            }
        }

        if (!$error["error"]) {
            $con2 = new conexion($dbTraslado);
            $sql2 = "INSERT INTO traslados 
        (uniqId, tiendaOrigen, tiendaTraslado, dbOrigen, dbTraslado, productos, comentario, idUserOrigen, estado) 
        VALUES(:uniqId, :tiendaOrigen, :tiendaTraslado, :dbOrigen, :dbTraslado, :productos, :comentarios, :idUserOrigen, :estado )";
            $result2 = $con2->SPCALLNR($sql, $data);
        }
        if ($result2['error'] != "00000") {
            $error['dbTraslate'] = "FAIL";
        } else {
            $error['dbTraslate'] = "SUCCESS";
            admin::saveLog(
                "Traslado",
                "Inventario",
                "Se actualizo la cantida del producto(s) por razones de Traslado",
                json_encode(["productos" => $productoModificado, "Tienda" => $tiendaTraslado]),
                $_SESSION['id']
            );
        }
        return $error;
    }

    public static function getTraslados()
    {
        $con = new conexion();
        $result = $con->SQND("SELECT * FROM traslados ORDER BY createAt DESC LIMIT 50");
        return $result;
    }

    public static function acceptTraslado($id, $dbOrigen, $dbTraslado)
    {
        /**
         *  Estados
         * 1: Pendiente
         * 2: Aceptado
         * 3: Cancelado
         * 4: devolucion
         * 5: AceptadaDevolucion
         */

        //Si pone 2 es por que es la DB a la cual se traslado el producto por ende se esta aceptando la trasferencia
        //Si pone 5 es por que somos la DB origen y el check es para aceptar una devolucion
        $db = $GLOBALS["DB_NAME"][$_SESSION['db']];
        $estado = $db  == $dbTraslado ? 2 : 5;
        $con = new conexion();
        $result = $con->SQNDNR("UPDATE traslados SET estado = $estado WHERE uniqId='$id'");
        $data = [];
        $data['dbNow'] = $result;
        if ($result['error'] == "00000") {
            if ($estado == 2) { // Esta en la DB de traslado
                $con1 = new conexion($dbOrigen); // actualizamos en Origen
                $result1 = $con1->SQNDNR("UPDATE traslados SET estado = $estado WHERE uniqId='$id'");
                $data['dbOrigen'] =  $result1;
                $data['dbTraslado'] =  null;
            } else {
                $con1 = new conexion($dbTraslado); // actualizamos en traslado
                $result1 = $con1->SQNDNR("UPDATE traslados SET estado = $estado WHERE uniqId='$id'");
                $data['dbTraslado'] =  $result1;
                $data['dbOrigen'] =  null;
            }
        }
        return $data;
    }

    public static function getTrasladobyId($id)
    {
        $con = new conexion();
        $result = $con->SQR_ONEROW("SELECT * FROM traslados WHERE uniqId ='$id'");
        return $result;
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
