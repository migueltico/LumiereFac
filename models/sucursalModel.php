<?php

namespace models;

use Config\helper as h;
use config\conexion;

class sucursalModel
{
    /**
     * obtiene todas las sucursales
     *
     * @return void
     */
    public static function getSucursal()
    {
        $con = new conexion();

        return $con->SQND('SELECT * FROM sucursal WHERE estado = 1');
    }
    public static function getAllSucursal()
    {
        $con = new conexion();

        return $con->SQND('SELECT * FROM sucursal');
    }

    /**
     * obtiene todos los productos
     *
     * @return void
     */
    public static function setSucursal($sucursal)
    {
        $con = new conexion();
        return $con->SPCALLR("CALL InsertSucursal(:sucursal, :ubicacion, :tel, :creado_por, :modificado_por)", $sucursal);
    }
    public static function updateSucursal($sucursal)
    {
        $con = new conexion();
        return $con->SPCALLR("CALL updateSucursal(:sucursal, :ubicacion, :tel, :modificado_por, :idsucursal)", $sucursal);
    }
    public static function getSucursalById($id)
    {
        $con = new conexion();
        $datos[':id'] = (int) $id;
        return $con->SRQ('SELECT * FROM sucursal WHERE idsucursal = :id', $datos);
    }
    public static function deleteSucursal($id)
    {
        $con = new conexion();
        $datos[':id'] = (int) $id;
        return $con->SRQ('DELETE FROM sucursal WHERE idsucursal = :id', $datos);
    }

    public static function createNewDataBAse($dbname)
    {
        $con = new conexion();
        $datos[':dbname'] = $dbname;
        $sql = "
        -- --------------------------------------------------------
        -- Host:                         127.0.0.1
        -- Versión del servidor:         10.4.13-MariaDB - mariadb.org binary distribution
        -- SO del servidor:              Win64
        -- HeidiSQL Versión:             11.0.0.5919
        -- --------------------------------------------------------
        
        /*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
        /*!40101 SET NAMES utf8 */;
        /*!50503 SET NAMES utf8mb4 */;
        /*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
        /*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
        
        
        -- Volcando estructura de base de datos para :dbname
        CREATE DATABASE IF NOT EXISTS ". $datos[':dbname']." /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
        USE ".$datos[':dbname'].";
        
        -- Volcando estructura para tabla :dbname.apartado
        CREATE TABLE IF NOT EXISTS `apartado` (
          `idapartado` int(11) NOT NULL AUTO_INCREMENT,
          `fecha_apartado` timestamp NULL DEFAULT current_timestamp(),
          `fecha_vencimiento` date DEFAULT NULL,
          `idventa` int(11) DEFAULT NULL,
          `idcliente` int(11) DEFAULT NULL,
          `idusuario` int(11) DEFAULT NULL,
          PRIMARY KEY (`idapartado`),
          KEY `idventa` (`idventa`),
          KEY `FK_apartado_cliente` (`idcliente`),
          KEY `FK_apartado_usuario` (`idusuario`),
          CONSTRAINT `FK_apartado_cliente` FOREIGN KEY (`idcliente`) REFERENCES `cliente` (`idcliente`),
          CONSTRAINT `FK_apartado_usuario` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`),
          CONSTRAINT `idventa` FOREIGN KEY (`idventa`) REFERENCES `venta` (`idventa`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        
        -- La exportación de datos fue deseleccionada.
        
        -- Volcando estructura para tabla :dbname.categoria
        CREATE TABLE IF NOT EXISTS `categoria` (
          `idcategoria` int(11) NOT NULL AUTO_INCREMENT,
          `descripcion` varchar(100) DEFAULT NULL,
          PRIMARY KEY (`idcategoria`)
        ) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;
        
        -- La exportación de datos fue deseleccionada.
        
        -- Volcando estructura para tabla :dbname.cliente
        CREATE TABLE IF NOT EXISTS `cliente` (
          `idcliente` int(11) NOT NULL AUTO_INCREMENT,
          `nombre` varchar(75) DEFAULT NULL,
          `cedula` int(11) DEFAULT NULL,
          `telefono` int(11) DEFAULT NULL,
          `email` varchar(75) DEFAULT NULL,
          `email_ad` int(11) DEFAULT NULL,
          `fecha` date DEFAULT NULL,
          `creado_el` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
          `creado_por` int(11) DEFAULT NULL,
          `ultima_modificacion` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
          `modificado_por` int(11) DEFAULT NULL,
          PRIMARY KEY (`idcliente`),
          KEY `FK_cliente_usuario` (`creado_por`),
          KEY `FK_cliente_usuario_2` (`modificado_por`),
          CONSTRAINT `FK_cliente_usuario` FOREIGN KEY (`creado_por`) REFERENCES `usuario` (`idusuario`),
          CONSTRAINT `FK_cliente_usuario_2` FOREIGN KEY (`modificado_por`) REFERENCES `usuario` (`idusuario`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        
        -- La exportación de datos fue deseleccionada.
        
        -- Volcando estructura para tabla :dbname.detalle_venta
        CREATE TABLE IF NOT EXISTS `detalle_venta` (
          `iddetalle_venta` int(11) NOT NULL AUTO_INCREMENT,
          `idproducto` int(11) DEFAULT NULL,
          `cantidad` int(11) DEFAULT NULL,
          `precio` decimal(10,2) DEFAULT NULL,
          `descuento` decimal(10,2) DEFAULT NULL,
          `iva` int(11) DEFAULT NULL,
          `total` decimal(10,2) DEFAULT NULL,
          PRIMARY KEY (`iddetalle_venta`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        
        -- La exportación de datos fue deseleccionada.
        
        -- Volcando estructura para tabla :dbname.historico_ingresos
        CREATE TABLE IF NOT EXISTS `historico_ingresos` (
          `idhistorico_ingresos` int(11) NOT NULL AUTO_INCREMENT,
          `cant` int(11) DEFAULT NULL,
          `precio` int(11) DEFAULT NULL,
          `update` int(11) DEFAULT NULL,
          `comentario` varchar(45) DEFAULT NULL,
          `idusuario` int(11) DEFAULT NULL,
          `idproducto` int(11) DEFAULT NULL,
          `creado_el` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
          PRIMARY KEY (`idhistorico_ingresos`),
          KEY `idusuario` (`idusuario`),
          KEY `idproducto` (`idproducto`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        
        -- La exportación de datos fue deseleccionada.
        
        -- Volcando estructura para tabla :dbname.log
        CREATE TABLE IF NOT EXISTS `log` (
          `idlog` int(11) NOT NULL AUTO_INCREMENT,
          `accion` varchar(45) DEFAULT NULL,
          `modulo` varchar(45) DEFAULT NULL,
          `detalle` varchar(255) DEFAULT NULL,
          `idusuario` int(11) DEFAULT NULL,
          `creado_el` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
          PRIMARY KEY (`idlog`),
          KEY `FK_log_usuario` (`idusuario`),
          CONSTRAINT `FK_log_usuario` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        
        -- La exportación de datos fue deseleccionada.
        
        -- Volcando estructura para tabla :dbname.producto
        CREATE TABLE IF NOT EXISTS `producto` (
          `idproducto` int(11) NOT NULL AUTO_INCREMENT,
          `descripcion` varchar(200) DEFAULT NULL,
          `marca` varchar(60) DEFAULT NULL,
          `estilo` varchar(60) DEFAULT NULL,
          `idcategoria` int(11) DEFAULT NULL,
          `idtalla` int(11) DEFAULT NULL,
          `codigo` varchar(100) DEFAULT NULL,
          `iva` int(3) DEFAULT 0,
          `activado_iva` int(1) DEFAULT 0,
          `creado_el` timestamp NULL DEFAULT current_timestamp(),
          `creado_por` int(11) DEFAULT NULL,
          `ultima_modificacion` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
          `modificado_por` int(11) DEFAULT NULL,
          `image_url` mediumtext DEFAULT NULL,
          PRIMARY KEY (`idproducto`),
          UNIQUE KEY `codigo` (`codigo`)
        ) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;
        
        -- La exportación de datos fue deseleccionada.
        
        -- Volcando estructura para tabla :dbname.rol
        CREATE TABLE IF NOT EXISTS `rol` (
          `idrol` int(11) NOT NULL AUTO_INCREMENT,
          `rol` varchar(45) DEFAULT NULL,
          `descripcion` varchar(100) DEFAULT NULL,
          `permisos` varchar(255) DEFAULT NULL,
          `creado_el` timestamp NULL DEFAULT current_timestamp(),
          `creado_por` int(11) DEFAULT NULL,
          `ultima_modificacion` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
          `modificado_por` int(11) DEFAULT NULL,
          PRIMARY KEY (`idrol`),
          KEY `FK_rol_usuario` (`creado_por`),
          KEY `FK_rol_usuario_2` (`modificado_por`),
          CONSTRAINT `FK_rol_usuario` FOREIGN KEY (`creado_por`) REFERENCES `usuario` (`idusuario`),
          CONSTRAINT `FK_rol_usuario_2` FOREIGN KEY (`modificado_por`) REFERENCES `usuario` (`idusuario`)
        ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
        
        -- La exportación de datos fue deseleccionada.
        
        -- Volcando estructura para tabla :dbname.stock
        CREATE TABLE IF NOT EXISTS `stock` (
          `idstock` int(11) NOT NULL AUTO_INCREMENT,
          `idproducto` int(11) DEFAULT NULL,
          `idsucursal` int(11) DEFAULT NULL,
          `stock` int(11) DEFAULT NULL,
          `precio_venta` decimal(10,2) DEFAULT NULL,
          `precio_costo` decimal(10,2) DEFAULT NULL,
          `modificado_por` int(11) DEFAULT NULL,
          `ultima_modificacion` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
          `estado` int(2) DEFAULT NULL,
          PRIMARY KEY (`idstock`),
          KEY `FK_stock_producto` (`idproducto`),
          KEY `FK_stock_usuario` (`modificado_por`),
          KEY `FK_stock_sucursal` (`idsucursal`),
          CONSTRAINT `FK_stock_sucursal` FOREIGN KEY (`idsucursal`) REFERENCES `sucursal` (`idsucursal`)
        ) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4;
        
        -- La exportación de datos fue deseleccionada.
        
        -- Volcando estructura para tabla :dbname.sucursal
        CREATE TABLE IF NOT EXISTS `sucursal` (
          `idsucursal` int(11) NOT NULL AUTO_INCREMENT,
          `descripcion` varchar(150) DEFAULT NULL,
          `ubicacion` varchar(250) DEFAULT NULL,
          `telefono` varchar(50) DEFAULT NULL,
          `creado_el` timestamp NULL DEFAULT current_timestamp(),
          `creado_por` int(11) DEFAULT NULL,
          `modificado_por` int(11) DEFAULT NULL,
          `ultima_modificacion` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
          `estado` int(11) DEFAULT NULL,
          PRIMARY KEY (`idsucursal`),
          KEY `FK_sucursal_usuario` (`creado_por`),
          KEY `FK_sucursal_usuario_2` (`modificado_por`),
          CONSTRAINT `FK_sucursal_usuario` FOREIGN KEY (`creado_por`) REFERENCES `usuario` (`idusuario`),
          CONSTRAINT `FK_sucursal_usuario_2` FOREIGN KEY (`modificado_por`) REFERENCES `usuario` (`idusuario`)
        ) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4;
        
        -- La exportación de datos fue deseleccionada.
        
        -- Volcando estructura para tabla :dbname.tallas
        CREATE TABLE IF NOT EXISTS `tallas` (
          `idtallas` int(11) NOT NULL AUTO_INCREMENT,
          `talla` varchar(45) DEFAULT NULL,
          `descripcion` varchar(70) DEFAULT NULL,
          PRIMARY KEY (`idtallas`)
        ) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
        
        -- La exportación de datos fue deseleccionada.
        
        -- Volcando estructura para tabla :dbname.tipo_venta
        CREATE TABLE IF NOT EXISTS `tipo_venta` (
          `idtipo_venta` int(11) NOT NULL AUTO_INCREMENT,
          `tipo_venta` int(11) DEFAULT NULL,
          `descripcion` int(11) DEFAULT NULL,
          PRIMARY KEY (`idtipo_venta`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        
        -- La exportación de datos fue deseleccionada.
        
        -- Volcando estructura para tabla :dbname.usuario
        CREATE TABLE IF NOT EXISTS `usuario` (
          `idusuario` int(11) NOT NULL AUTO_INCREMENT,
          `usuario` varchar(50) DEFAULT NULL,
          `password` varchar(15) DEFAULT NULL,
          `email` varchar(80) DEFAULT NULL,
          `nombre` varchar(100) DEFAULT NULL,
          `telefono` varchar(11) DEFAULT NULL,
          `direccion` varchar(255) DEFAULT NULL,
          `codigo` varchar(50) DEFAULT NULL,
          `estado` int(11) DEFAULT NULL,
          `rol` int(11) DEFAULT NULL,
          `idsucursal` int(11) DEFAULT NULL,
          PRIMARY KEY (`idusuario`),
          KEY `FK_usuario_rol` (`rol`),
          KEY `FK_usuario_sucursal` (`idsucursal`),
          CONSTRAINT `FK_usuario_rol` FOREIGN KEY (`rol`) REFERENCES `rol` (`idrol`)
        ) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
        
        -- La exportación de datos fue deseleccionada.
        
        -- Volcando estructura para tabla :dbname.venta
        CREATE TABLE IF NOT EXISTS `venta` (
          `idventa` int(11) NOT NULL AUTO_INCREMENT,
          `idusuario` int(11) DEFAULT NULL,
          `idusuario_venta` int(11) DEFAULT NULL,
          `idtipo_venta` int(11) DEFAULT NULL,
          `fecha` timestamp NULL DEFAULT current_timestamp(),
          `impuesto` decimal(10,2) DEFAULT NULL,
          `descuento` decimal(6,2) DEFAULT NULL,
          `total` decimal(10,2) DEFAULT NULL,
          `estado` int(11) DEFAULT NULL,
          `comentario` varchar(255) DEFAULT NULL,
          PRIMARY KEY (`idventa`),
          KEY `FK_venta_usuario` (`idusuario`),
          KEY `FK_venta_usuario_2` (`idusuario_venta`),
          KEY `FK_venta_tipo_venta` (`idtipo_venta`),
          CONSTRAINT `FK_venta_tipo_venta` FOREIGN KEY (`idtipo_venta`) REFERENCES `tipo_venta` (`idtipo_venta`),
          CONSTRAINT `FK_venta_usuario` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`),
          CONSTRAINT `FK_venta_usuario_2` FOREIGN KEY (`idusuario_venta`) REFERENCES `usuario` (`idusuario`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        
        -- La exportación de datos fue deseleccionada.
        
        -- Volcando estructura para procedimiento :dbname.getAllProduct
        DELIMITER //
        CREATE PROCEDURE `getAllProduct`()
        BEGIN	
            SELECT p.idproducto,u.nombre, p.descripcion, p.image_url, p.idtalla,p.idcategoria, p.codigo,p.marca, c.descripcion AS categoria,p.estilo, t.talla AS talla,p.iva, p.activado_iva, p.ultima_modificacion, SUM(s.stock) AS stock, s.idsucursal, s.estado, (
            SELECT GROUP_CONCAT(s.idsucursal,'') AS id
            FROM stock AS s
            WHERE idproducto =p.idproducto AND s.estado = 1
                ) AS sucursales
            FROM producto AS p
            INNER JOIN categoria AS c ON p.idcategoria = c.idcategoria
            INNER JOIN usuario AS u ON p.modificado_por = u.idusuario
            INNER JOIN tallas AS t ON p.idtalla = t.idtallas
            INNER JOIN stock AS s ON p.idproducto = s.idproducto
            GROUP BY s.idproducto;
        END//
        DELIMITER ;
        
        -- Volcando estructura para procedimiento :dbname.getProductBySucursal
        DELIMITER //
        CREATE PROCEDURE `getProductBySucursal`(
            IN `Param1` INT
        )
        BEGIN	
            SELECT p.idproducto,u.nombre, p.descripcion, p.image_url, t.descripcion AS talla_descripcion, p.idtalla,p.idcategoria, p.codigo,p.marca, c.descripcion AS categoria,p.estilo, t.talla AS talla,p.iva, p.activado_iva, p.ultima_modificacion, s.stock, s.idsucursal, s.estado, (
            SELECT GROUP_CONCAT(s.idsucursal,'') AS id
            FROM stock AS s
            WHERE idproducto =p.idproducto AND s.estado = 1
                    ) AS sucursales,
                     (
            SELECT GROUP_CONCAT(ss.descripcion,'') AS id
            FROM sucursal AS ss WHERE ss.estado = 1
                    ) AS sucursalesName 
            FROM producto AS p
            INNER JOIN categoria AS c ON p.idcategoria = c.idcategoria
            INNER JOIN usuario AS u ON p.modificado_por = u.idusuario
            INNER JOIN tallas AS t ON p.idtalla = t.idtallas
            INNER JOIN stock AS s ON p.idproducto = s.idproducto
            WHERE s.idproducto = param1
            GROUP BY s.idproducto;
        END//
        DELIMITER ;
        
        -- Volcando estructura para procedimiento :dbname.getProductsBySucursal
        DELIMITER //
        CREATE PROCEDURE `getProductsBySucursal`(
            IN `idsucursal` INT
        )
        BEGIN	
            SELECT p.idproducto,u.nombre, p.descripcion, p.image_url, p.idtalla,p.idcategoria, p.codigo,p.marca, c.descripcion AS categoria,p.estilo, t.talla AS talla,p.iva, p.activado_iva, p.ultima_modificacion, s.stock, s.idsucursal, s.estado, (
            SELECT GROUP_CONCAT(s.idsucursal,'') AS id
            FROM stock AS s
            WHERE idproducto =p.idproducto
                ) AS sucursales
            FROM producto AS p
            INNER JOIN categoria AS c ON p.idcategoria = c.idcategoria
            INNER JOIN usuario AS u ON p.modificado_por = u.idusuario
            INNER JOIN tallas AS t ON p.idtalla = t.idtallas
            INNER JOIN stock AS s ON p.idproducto = s.idproducto
            WHERE s.idsucursal = idsucursal AND s.estado = 1
            GROUP BY s.idproducto;
        END//
        DELIMITER ;
        
        -- Volcando estructura para procedimiento :dbname.InsertSucursal
        DELIMITER //
        CREATE PROCEDURE `InsertSucursal`(
            IN `Param1` VARCHAR(150),
            IN `Param2` VARCHAR(250),
            IN `Param3` VARCHAR(50),
            IN `Param4` INT,
            IN `Param5` INT
        )
        BEGIN
            INSERT INTO sucursal (descripcion, ubicacion, telefono, creado_por, modificado_por) VALUES(param1,param2,param3,param4,param5);
        END//
        DELIMITER ;
        
        -- Volcando estructura para procedimiento :dbname.updateProduct
        DELIMITER //
        CREATE PROCEDURE `updateProduct`(
            IN `Param1` VARCHAR(200),
            IN `Param2` VARCHAR(60),
            IN `Param3` VARCHAR(60),
            IN `Param4` INT,
            IN `Param5` INT,
            IN `Param6` VARCHAR(100),
            IN `Param7` INT,
            IN `Param8` INT,
            IN `Param9` INT,
            IN `Param10` VARCHAR(20000),
            IN `Param11` INT
        )
        BEGIN
            UPDATE producto AS p
            SET p.descripcion = param1, p.marca = param2, p.estilo = param3, p.idcategoria = param4, p.idtalla = param5,
             p.codigo = param6, p.iva = param7, p.activado_iva = param8, p.modificado_por = param9 ,p.image_url = param10
            WHERE p.idproducto = param11;
        END//
        DELIMITER ;
        
        -- Volcando estructura para procedimiento :dbname.updateProductStataBySucursal
        DELIMITER //
        CREATE PROCEDURE `updateProductStataBySucursal`(
            IN `Param1` INT,
            IN `Param2` INT,
            IN `Param3` INT
        )
        BEGIN
            UPDATE stock AS s
            SET s.estado = param1
            WHERE s.idsucursal = param2 AND  s.idproducto = param3;
        END//
        DELIMITER ;
        
        -- Volcando estructura para procedimiento :dbname.updateSucursal
        DELIMITER //
        CREATE PROCEDURE `updateSucursal`(
            IN `Param1` VARCHAR(150),
            IN `Param2` VARCHAR(250),
            IN `Param3` VARCHAR(50),
            IN `Param4` INT,
            IN `Param5` INT
        )
        BEGIN
            UPDATE sucursal AS s SET s.descripcion = param1, s.ubicacion = param2, s.telefono = param3, s.modificado_por = param4 WHERE s.idsucursal = param5;
        END//
        DELIMITER ;
        
        /*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
        /*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
        /*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
        

        ";
        return $con->SRQ($sql, $datos);
    }
}
