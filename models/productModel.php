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
    public static function Addproduct($datos, $sucursal)
    {
        $con = new conexion();
        $mainProduct = $con->SQ(
            'INSERT INTO producto (descripcion,marca,estilo,idcategoria,idtalla,codigo,iva,activado_iva,creado_por,modificado_por,image_url)
            VALUES (:descripcion,:marca,:estilo,:categoria,:talla,:codigoBarras,:iva_valor,:iva,:idusuario,:idusuario,:urls)',
            $datos
        );
        $datos2 = array(
            ":idusuario" => (int) $datos[':idusuario']
        );
        $totalErrors = 0;
        $stockProducts = [];
        if ($mainProduct['error'] == '00000') {

            $idproduct = $con->SRQ(
                'SELECT * FROM producto WHERE idproducto=(SELECT MAX(idproducto) FROM producto WHERE creado_por=:idusuario)',
                $datos2
            );
            $idproduct = $idproduct['data'];
            $datos3 = array(
                ":idproducto" => (int) $idproduct['idproducto'],
                ":idusuario" => (int) $datos[':idusuario']
            );

            foreach ($sucursal as $item) {
                $stockProduct = $con->SQ(
                    "INSERT INTO stock (idproducto,idsucursal,stock,precio_venta,precio_costo,modificado_por,estado)
                VALUES (:idproducto,$item,0,0,0,:idusuario,1)",
                    $datos3
                );
                if ($stockProduct['error'] !== '00000') $totalErrors++;
                array_push($stockProducts, $stockProduct);
            }
        }
        if ($mainProduct['error'] == '00000' &&  $totalErrors == 0) {
            return array("data" => null, "error" => 0, "msg" => "Registros ingresados correctamente");
        } else if ($mainProduct['error'] !== '00000') {
            return array("data" => null, "error" => 1,   "errorData" => $mainProduct, "msg" => "Error al Registras los datos");
        } else {
            return array("data" => null, "error" => 1,   "errorData" => $stockProducts, "msg" => "Error al Registras los datos");
        }
    }
    /**
     * obtiene todos los productos
     *
     * @return void
     */
    public static function getProductsBySucursal($sucursal)
    {
        $con = new conexion();
        return $con->SPCALL("CALL getProductsBySucursal($sucursal)");
    }
    /**
     * obtiene todos los productos
     *
     * @return void
     */
    public static function getProductBySucursal($id)
    {
        $con = new conexion();
        $result = $con->SPCALL("CALL getProductBySucursal($id)");
        if ($result['error'] == '00000') {
            return array("data" =>  $result['data'], "rows" => $result['rows'], "error" => 0, "msg" => "Registros cargados correctamente");
        } else if ($result['error'] !== '00000') {
            return array("data" =>  $result['data'], "rows" => $result['rows'], "error" => 1,   "errorData" => $result, "msg" => "Error al Cargar los datos");
        }
    }
    /**
     * obtiene todos los productos por grupo
     *
     * @return void
     */
    public static function getProductsByGroup()
    {
        $con = new conexion();

        return $con->SQND('SELECT p.idproducto, p.descripcion,s.estado,p.codigo,p.marca, c.descripcion AS categoria,p.estilo, t.talla AS talla,p.iva, p.activado_iva,p.ultima_modificacion, SUM(s.stock) AS total_stock,s.stock, s.idsucursal, COUNT(*) AS Total_sucursal
        FROM producto AS p
        INNER JOIN categoria AS c ON p.idcategoria = c.idcategoria
        INNER JOIN tallas AS t ON p.idtalla = t.idtallas
        INNER JOIN stock AS s ON p.idproducto = s.idproducto
        GROUP BY s.idproducto
        ');
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
     * Obtiene todas las tallas
     *
     * @return void
     */
    public static function updateProduct($datos)
    {
        $con = new conexion();
        $setData = ':descripcion,:marca,:estilo,:categoria,:talla,:codigoBarras,:iva_valor,:iva,:modificado_por,:urls,:idproducto';
        $sql = "CALL updateProduct($setData)";
        return $con->SPCALLNR($sql, $datos);
        // $arr  =   array(
        //     "p.descripcion" => "param1",
        //     "p.marca" => "param2",
        //     "p.estilo" => "param3",
        //     "p.idcategoria" => "param4",
        //     "p.idtalla" => "param5",
        //     "p.codigo" => "param6",
        //     "p.iva" => "param7",
        //     "p.activado_iva" => "param8",
        //     "p.modificado_por" => "param9",
        //     "p.image_url" => "param10",
        //     "p.idproducto" => "param11"
        // );
    }
}
