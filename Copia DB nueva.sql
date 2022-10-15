-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 14-10-2022 a las 23:48:00
-- Versión del servidor: 8.0.30-0ubuntu0.20.04.2
-- Versión de PHP: 7.4.3
--CAMBAIR NOMBRE DE LA DB
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Base de datos: `CHANGENAMEDB`
--
DROP DATABASE IF EXISTS `CHANGENAMEDB`;
CREATE DATABASE IF NOT EXISTS `CHANGENAMEDB` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `CHANGENAMEDB`;

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `Aa_test` (IN `Param1` INT)  BEGIN
SET @products = (SELECT * FROM producto);
SET @gastos = (SELECT * FROM gastos);
SELECT IF(param1>0,@gastos,@products);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getGeneralInfo` ()  BEGIN
	SELECT * FROM generalinfo WHERE generalinfo.idgeneral = 1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertSucursal` (IN `Param1` VARCHAR(150), IN `Param2` VARCHAR(250), IN `Param3` VARCHAR(50), IN `Param4` INT, IN `Param5` INT)  BEGIN
	INSERT INTO sucursal (descripcion, ubicacion, telefono, creado_por, modificado_por) VALUES(param1,param2,param3,param4,param5);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_addCategorias` (IN `Param1` VARCHAR(75))  BEGIN
	INSERT INTO categoria (descripcion) VALUE(param1);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_addCategoriasPrecios` (IN `Param1` VARCHAR(50), IN `Param2` DOUBLE, IN `Param3` INT)  BEGIN
	INSERT INTO categoria_precios(descripcion,factor,creado_por,modificado_por) VALUES(param1, param2, param3, param3);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_addGastos` (IN `Param1` VARCHAR(5000), IN `Param2` DOUBLE, IN `Param3` INT)  BEGIN
	INSERT INTO gastos (idgastos, gastos,total,modificado_por) VALUES(1, param1, param2, param3) ON DUPLICATE KEY UPDATE    
	gastos=param1, total = param2, modificado_por = param3;
       
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_addGeneralInfo` (IN `Param1` VARCHAR(50), IN `Param2` VARCHAR(50), IN `Param3` VARCHAR(50), IN `Param4` VARCHAR(50), IN `Param5` VARCHAR(200), IN `Param6` VARCHAR(50), IN `Param7` VARCHAR(50), IN `Param8` VARCHAR(60), IN `Param9` VARCHAR(60), IN `Param10` VARCHAR(50), IN `Param11` INT)  BEGIN
	INSERT INTO generalinfo (idgeneral,nombre_local,razon_social,cedula_juridica,telefono,direccion,correo_info,correo_venta,mensaje_footer_fac,mensaje_restricciones,url_logo, idclienteGenerico) 
	VALUES(1, param1, param2, param3, param4, param5, param6, param7, param8, param9, param10, param11) ON DUPLICATE KEY UPDATE    
	nombre_local=param1, razon_social = param2, cedula_juridica = param3, telefono = param4, direccion = param5, correo_info = param6, correo_venta = param7, mensaje_footer_fac = param8, mensaje_restricciones = param9, url_logo = param10, idclienteGenerico=param11;       
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_addNewClient` (IN `Param1` VARCHAR(75), IN `Param2` VARCHAR(50), IN `Param3` VARCHAR(50), IN `Param4` VARCHAR(255), IN `Param5` VARCHAR(100), IN `Param6` INT)  BEGIN
	INSERT INTO cliente(nombre, cedula, telefono, direccion, email, creado_por, modificado_por) VALUES (param1, param2, param3, param4, param5, param6, param6);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_addTallas` (IN `Param1` VARCHAR(50), IN `Param2` VARCHAR(50))  BEGIN
 INSERT INTO tallas (descripcion,talla) VALUES(param1, param2);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_decrementConsecutiveFac` ()  BEGIN	
		SET @valor =0;
		SELECT consecutivos.fac INTO @value
		FROM consecutivos
		WHERE consecutivos.idconsecutivos = 1
		FOR UPDATE;
		
		UPDATE consecutivos
		SET fac = @VALUE - 1
		WHERE idconsecutivos =1;
	
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_EditCategoriasPrecios` (IN `Param1` VARCHAR(50), IN `Param2` DOUBLE, IN `Param3` INT, IN `Param4` INT)  BEGIN
	UPDATE categoria_precios AS cp  SET cp.descripcion=param1, cp.factor = param2 , cp.modificado_por = param3 WHERE cp.idCategoriaPrecio = param4;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_getAllProduct` ()  BEGIN	
	SELECT p.*, c.descripcion AS categoria,p.estilo, t.talla AS talla
	FROM producto AS p
	INNER JOIN categoria AS c ON p.idcategoria = c.idcategoria
	LEFT JOIN usuario AS u ON p.modificado_por = u.idusuario
	INNER JOIN tallas AS t ON p.idtalla = t.idtallas
	ORDER BY p.idproducto ASC;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_getCategoriaPrecios` ()  BEGIN
	SELECT * FROM categoria_precios;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_getCategorias` ()  BEGIN
 SELECT * FROM categoria;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_getClienteById` (IN `Param1` INT)  BEGIN
	SELECT * FROM cliente WHERE idcliente = param1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_getFactorProduct` (IN `Param1` INT)  BEGIN
	SELECT cp.factor
	FROM categoria_precios AS cp
	WHERE cp.idCategoriaPrecio = (
	SELECT categoriaPrecio
	FROM producto AS p
	WHERE p.idproducto = param1);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_getProductById` (IN `Param1` INT)  BEGIN	
	SELECT p.*, t.descripcion AS talla_descripcion,c.descripcion AS categoria,t.talla AS talla
	FROM producto AS p
	INNER JOIN categoria AS c ON p.idcategoria = c.idcategoria
	LEFT JOIN usuario AS u ON p.modificado_por = u.idusuario
	INNER JOIN tallas AS t ON p.idtalla = t.idtallas
	WHERE p.idproducto = param1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_getProducts` ()  BEGIN	
	SELECT p.*, c.descripcion AS categoria,p.estilo, t.talla AS talla
	FROM producto AS p
	INNER JOIN categoria AS c ON p.idcategoria = c.idcategoria
	LEFT JOIN usuario AS u ON p.modificado_por = u.idusuario
	INNER JOIN tallas AS t ON p.idtalla = t.idtallas
	WHERE p.estado = 1 ORDER BY p.idproducto ASC;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_getTallas` ()  BEGIN
	SELECT *  FROM tallas;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_incrementConsecutiveFac` ()  BEGIN	
		SET @valor =0;
		SELECT consecutivos.fac INTO @value
		FROM consecutivos
		WHERE consecutivos.idconsecutivos = 1
		FOR UPDATE;
		
		UPDATE consecutivos
		SET fac = @value + 1
		WHERE idconsecutivos =1;
		
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insertFactDetails` (IN `_idfactura` BIGINT, IN `_idproducto` INT, IN `_cantidad` INT, IN `_precio` DOUBLE(10,2), IN `_descuento` INT, IN `_iva` INT, IN `_total` DOUBLE(10,2))  BEGIN
	INSERT INTO detalle_factura (idfactura, idproducto, cantidad, precio, descuento, iva, total)
	VALUE (_idfactura, _idproducto, _cantidad, _precio, _descuento, _iva, _total);
	SET @stockNow = (SELECT Stock FROM producto WHERE idproducto =_idproducto);
	UPDATE producto SET Stock = (@stockNow - _cantidad) WHERE idproducto =_idproducto;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insertUser` (IN `_usuario` VARCHAR(50), IN `_email` VARCHAR(80), IN `_nombre` VARCHAR(100), IN `_telefono` VARCHAR(50), IN `_direccion` VARCHAR(255), IN `_estado` INT, IN `_rol` INT, IN `_identificador` VARCHAR(50))  BEGIN
INSERT INTO usuario (usuario,email,nombre,telefono,direccion,estado,rol,identificador)
VALUE(_usuario,_email,_nombre,_telefono,_direccion,_estado,_rol,_identificador);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_reporteDiario` (IN `param1` VARCHAR(50), IN `param2` VARCHAR(50))  NO SQL
BEGIN
CREATE TEMPORARY TABLE `tmp_reporteDiario` (efectivo DOUBLE(10,2),tarjeta DOUBLE(10,2),transferencia DOUBLE(10,2),fecha DATE);
INSERT INTO `tmp_reporteDiario` SELECT f.monto_efectivo, f.monto_tarjeta, f.monto_transferencia, f.formatDate FROM facturas AS f WHERE f.formatDate BETWEEN param1 AND param2;
INSERT INTO `tmp_reporteDiario` SELECT r.monto_efectivo, r.monto_tarjeta, r.monto_transferencia, r.fechaFormat FROM recibos AS r WHERE r.fechaFormat BETWEEN param1 AND param2;

SELECT SUM(efectivo) AS total_efectivo, SUM(tarjeta) AS total_tarjeta, SUM(transferencia) AS total_transferencia, (SUM(efectivo)+SUM(tarjeta)+SUM(transferencia)) AS total_diario, fecha, COUNT(fecha) AS cantidad
FROM `tmp_reporteDiario` GROUP BY fecha;

DROP TEMPORARY TABLE `tmp_reporteDiario`;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_reporteDiarioDetallado` (IN `param1` VARCHAR(50), IN `param2` VARCHAR(50))  NO SQL
BEGIN
DROP TABLE IF EXISTS `tmp_reporteDiarioDetallado`;
CREATE TEMPORARY TABLE tmp_reporteDiarioDetallado (
	docNum BIGINT(22),
	docRef BIGINT(22),
	efectivo DOUBLE(10,2),
	tarjeta DOUBLE(10,2),
	transferencia DOUBLE(10,2),
	referencia_t VARCHAR(255),
	banco VARCHAR(50),
	descuento DOUBLE(10,2),
	impuesto DOUBLE(10,2),
	total DOUBLE(10,2),
	tipoDoc VARCHAR(50),
	doc VARCHAR(50),
	t_efectivo INT,
	t_tarjeta INT,	
	t_transferencia INT,
	caja INT,
	fecha DATE,
    fechaTime TIMESTAMP,
	n_tarjeta INT, 
	n_tarjeta_multi VARCHAR(255)
	);


INSERT INTO tmp_reporteDiarioDetallado
 SELECT 
 f.consecutivo,
 NULL,
 f.monto_efectivo,
 f.monto_tarjeta,
 f.monto_transferencia,
 f.referencia_transferencia,
 f.banco_transferencia,
 f.descuento,
 f.impuesto,
 (f.monto_efectivo+ f.monto_tarjeta+f.monto_transferencia),
 (CASE
    WHEN f.tipo = 1 THEN "Compra"
    WHEN f.tipo = 2 THEN "Envio" 
    WHEN f.tipo = 3 THEN "Apartado"
 END),
 'FAC',
 f.efectivo,
 f.tarjeta,
 f.transferencia,
 f.idcaja,
 f.formatDate, 
 f.fecha,
 f.numero_tarjeta, 
 f.multipago_string 
 FROM facturas AS f WHERE f.formatDate 
 BETWEEN param1 AND param2;
 
 INSERT INTO tmp_reporteDiarioDetallado
 SELECT 
 r.idrecibo,
 r.idfactura,
 r.monto_efectivo,
 r.monto_tarjeta,
 r.monto_transferencia,
 r.referencia_transferencia,
 r.banco_transferencia,
 0,
 0,
 (r.monto_efectivo+ r.monto_tarjeta+r.monto_transferencia),
 "Abono",
 'RECIBO',
 r.efectivo,
 r.tarjeta, 
 r.transferencia,
 r.idcaja,
 r.fechaFormat, 
 r.fecha, 
 r.numero_tarjeta, 
 r.multipago_string 
 FROM recibos AS r WHERE r.fechaFormat 
 BETWEEN param1 AND param2;

SELECT * FROM tmp_reporteDiarioDetallado ORDER BY fechaTime DESC;

DROP TEMPORARY TABLE tmp_reporteDiarioDetallado;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_reporteFacturaDetallada_por_metodo_pago` (IN `param1` VARCHAR(50), IN `param2` VARCHAR(50), IN `param3` INT)  NO SQL
BEGIN
CREATE TEMPORARY TABLE tmp_reporteDiarioDetallado_metod_pago (
	docNum BIGINT(22),
	efectivo DOUBLE(10,2),
	tarjeta DOUBLE(10,2),
	transferencia DOUBLE(10,2),
	total DOUBLE(10,2),
	tipoDoc VARCHAR(50),
	doc VARCHAR(50),
	t_efectivo INT,
	t_tarjeta INT,
	t_transferencia INT,
	caja INT,
	fecha DATE
	);


INSERT INTO tmp_reporteDiarioDetallado_metod_pago
 SELECT 
 f.consecutivo,
 f.monto_efectivo,
 f.monto_tarjeta,
 f.monto_transferencia,
 (f.monto_efectivo+ f.monto_tarjeta+f.monto_transferencia),
 (CASE
    WHEN f.tipo = 1 THEN "Compra"
    WHEN f.tipo = 2 THEN "Envio" 
    WHEN f.tipo = 3 THEN "Apartado"
 END),
 'FAC',
 f.efectivo,
 f.tarjeta,
 f.transferencia,
 f.idcaja,
 f.formatDate 
 FROM facturas AS f WHERE f.formatDate 
 BETWEEN param1 AND param2  
 AND (CASE
    WHEN param3 = 1 THEN f.efectivo = 1
    WHEN param3 = 2 THEN f.tarjeta = 1
    WHEN param3 = 3 THEN f.transferencia = 1
 END);
 
 INSERT INTO tmp_reporteDiarioDetallado_metod_pago
 SELECT 
 r.idrecibo,
 r.monto_efectivo,
 r.monto_tarjeta,
 r.monto_transferencia,
 (r.monto_efectivo+ r.monto_tarjeta+r.monto_transferencia),
 "Abono",
 'RECIBO',
 r.efectivo,
 r.tarjeta,
 r.transferencia,
 r.idcaja,
 r.fechaFormat 
 FROM recibos AS r WHERE r.fechaFormat 
 BETWEEN param1 AND param2  
 AND (CASE
    WHEN param3 = 1 THEN r.efectivo = 1
    WHEN param3 = 2 THEN r.tarjeta = 1
    WHEN param3 = 3 THEN r.transferencia = 1
 END);

SELECT * FROM tmp_reporteDiarioDetallado_metod_pago ORDER BY fecha DESC;

DROP TEMPORARY TABLE tmp_reporteDiarioDetallado_metod_pago;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_saveLog` (IN `Param1` VARCHAR(50), IN `Param2` VARCHAR(50), IN `Param3` VARCHAR(255), IN `Param4` TEXT, IN `Param5` INT)  BEGIN
	INSERT INTO log (accion, modulo, detalle, datos, idusuario) VALUES	(param1, param2, param3, param4, param5);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_searchClient` (IN `Param1` VARCHAR(50), IN `Param2` INT, IN `Param3` INT)  BEGIN	
	SELECT c.nombre ,c.cedula, c.email, c.idcliente, c.telefono
	FROM cliente AS c
	WHERE (c.nombre LIKE param1 OR c.cedula LIKE param1) AND c.estado = 1 ORDER BY c.idcliente ASC LIMIT param2, param3;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_searchCodeProduct` (IN `Param1` VARCHAR(150))  BEGIN	
	SELECT p.*, c.descripcion AS categoria,p.estilo, t.talla AS talla, d.iddescuento,d.descripcion AS descuento_descripcion, d.descuento
	FROM producto AS p
	INNER JOIN categoria AS c ON p.idcategoria = c.idcategoria
	LEFT JOIN usuario AS u ON p.modificado_por = u.idusuario
	INNER JOIN tallas AS t ON p.idtalla = t.idtallas
	LEFT OUTER JOIN descuentos AS d ON p.iddescuento = d.iddescuento
	WHERE p.codigo = param1 AND p.estado = 1
	ORDER BY p.idproducto ASC;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_searchCodeProductCtrlQ` (IN `Param1` VARCHAR(70), IN `Param2` INT, IN `Param3` INT)  BEGIN	
	SELECT p.*, c.descripcion AS categoria,p.estilo, t.talla AS talla, d.iddescuento,d.descripcion AS descuento_descripcion, d.descuento
	FROM producto AS p
	INNER JOIN categoria AS c ON p.idcategoria = c.idcategoria
	LEFT JOIN usuario AS u ON p.modificado_por = u.idusuario
	INNER JOIN tallas AS t ON p.idtalla = t.idtallas
	LEFT OUTER JOIN descuentos AS d ON p.iddescuento = d.iddescuento
	WHERE (p.descripcion LIKE param1 OR p.marca  LIKE param1 OR p.estilo LIKE param1 OR p.codigo LIKE param1) AND p.estado = 1 ORDER BY p.idproducto ASC LIMIT param2, param3;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_searchCodeProductWithState` (IN `Param1` VARCHAR(150), IN `Param2` INT, IN `Param3` INT, IN `Param4` INT)  BEGIN	
	SELECT p.*, c.descripcion AS categoria,p.estilo, t.talla AS talla, d.iddescuento,d.descripcion AS descuento_descripcion, d.descuento
	FROM producto AS p
	INNER JOIN categoria AS c ON p.idcategoria = c.idcategoria
	LEFT JOIN usuario AS u ON p.modificado_por = u.idusuario
	INNER JOIN tallas AS t ON p.idtalla = t.idtallas
	LEFT OUTER JOIN descuentos AS d ON p.iddescuento = d.iddescuento
	WHERE (p.descripcion LIKE param1 OR p.marca  LIKE param1 OR p.estilo LIKE param1 OR p.codigo LIKE param1) AND p.estado = param4 ORDER BY p.idproducto ASC LIMIT param2, param3;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_searchProductById` (IN `Param1` VARCHAR(11))  BEGIN	
	SELECT p.*, c.descripcion AS categoria,p.estilo, t.talla AS talla
	FROM producto AS p
	INNER JOIN categoria AS c ON p.idcategoria = c.idcategoria
	LEFT JOIN usuario AS u ON p.modificado_por = u.idusuario
	INNER JOIN tallas AS t ON p.idtalla = t.idtallas
	WHERE p.idproducto = param1
	ORDER BY p.idproducto ASC;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_searchProductLike` (IN `Param1` VARCHAR(250))  BEGIN	
	SELECT p.*, c.descripcion AS categoria,p.estilo, t.talla AS talla
	FROM producto AS p
	INNER JOIN categoria AS c ON p.idcategoria = c.idcategoria
	LEFT JOIN usuario AS u ON p.modificado_por = u.idusuario
	INNER JOIN tallas AS t ON p.idtalla = t.idtallas
	WHERE (p.descripcion LIKE param1 OR p.codigo LIKE param1 OR p.idproducto LIKE param1)
	ORDER BY p.idproducto ASC;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_SearchProduct_Inventario` (IN `Param1` VARCHAR(70))  BEGIN	
	SELECT COUNT(p.idproducto) AS cantidad
	FROM producto AS p
	INNER JOIN categoria AS c ON p.idcategoria = c.idcategoria
	LEFT JOIN usuario AS u ON p.modificado_por = u.idusuario
	INNER JOIN tallas AS t ON p.idtalla = t.idtallas
	LEFT OUTER JOIN descuentos AS d ON p.iddescuento = d.iddescuento
	WHERE (p.descripcion LIKE param1 OR p.marca  LIKE param1 OR p.estilo LIKE param1 OR p.codigo LIKE param1) AND p.estado = 1 ORDER BY p.idproducto ASC;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_updateCategoria` (IN `Param1` VARCHAR(50), IN `Param2` INT)  BEGIN
 UPDATE categoria SET categoria.descripcion = param1 WHERE categoria.idcategoria = param2;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_updateClienteById` (IN `Param1` VARCHAR(75), IN `Param2` VARCHAR(50), IN `Param3` VARCHAR(50), IN `Param4` VARCHAR(255), IN `Param5` VARCHAR(100), IN `Param6` INT, IN `Param7` INT)  BEGIN
 UPDATE cliente AS c SET c.nombre = param1, c.cedula = param2, c.telefono = param3, c.direccion = param4, c.email = param5, c.modificado_por = param6 WHERE c.idcliente = param7;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_updateMinStockProduct` (IN `Param1` INT, IN `Param2` INT)  BEGIN
	UPDATE producto AS p SET p.min_stock =param2 WHERE p.idproducto=param1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_updatePriceProduct` (IN `Param1` INT, IN `Param2` INT, IN `Param3` INT, IN `Param4` INT, IN `Param5` INT)  BEGIN
	#SET @newStock = (SELECT SUM(p.stock + param1) AS total FROM producto AS p WHERE p.idproducto =param2);
	UPDATE producto AS p SET p.precio_costo = param2, p.precio_venta = param3, p.precio_unitario = param4, p.precio_sugerido = param5 WHERE p.idproducto=param1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_updateProduct` (IN `Param1` VARCHAR(200), IN `Param2` VARCHAR(60), IN `Param3` VARCHAR(60), IN `Param4` INT, IN `Param5` INT, IN `Param6` VARCHAR(100), IN `Param7` INT, IN `Param8` INT, IN `Param9` INT, IN `Param10` VARCHAR(20000), IN `Param11` INT, IN `Param12` INT, IN `Param13` INT, IN `Param14` INT, IN `_descripcion_short` VARCHAR(30))  BEGIN
	UPDATE producto AS p
	SET p.descripcion = param1, p.marca = param2, p.estilo = param3, p.idcategoria = param4, p.idtalla = param5,
	 p.codigo = param6, p.iva = param7, p.activado_iva = param8, p.modificado_por = param9 ,p.image_url = param10 ,p.estado = param11, categoriaPrecio = param12, iddescuento = param13, descripcion_short = _descripcion_short
	WHERE p.idproducto = param14;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_updateStockProduct` (IN `Param1` INT, IN `Param2` INT)  BEGIN
	SET @newStock = (SELECT SUM(p.stock + param2) AS total FROM producto AS p WHERE p.idproducto =param1);
	UPDATE producto AS p SET p.stock =@newStock WHERE p.idproducto=param1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_updateTalla` (IN `Param1` VARCHAR(50), IN `Param2` VARCHAR(50), IN `Param3` INT)  BEGIN
	UPDATE tallas SET descripcion = param1, talla = param2 WHERE idtallas = param3;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ventasXclienteXfecha` (IN `param1` VARCHAR(50), IN `param2` VARCHAR(50))  NO SQL
SELECT f.formatDate as Fecha, f.consecutivo as Factura, c.nombre as Nombre, c.telefono as Telefono, f.total as Total FROM `facturas` AS f INNER JOIN cliente AS c ON c.idcliente = f.idcliente WHERE f.fecha BETWEEN param1 AND param2$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `apartado`
--

CREATE TABLE `apartado` (
  `idapartado` int NOT NULL,
  `fecha_apartado` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_vencimiento` date DEFAULT NULL,
  `idventa` int DEFAULT NULL,
  `idcliente` int DEFAULT NULL,
  `idusuario` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cajas`
--

CREATE TABLE `cajas` (
  `idcaja` int NOT NULL,
  `idusuario_openbox` int DEFAULT NULL,
  `idvendedor` int DEFAULT NULL,
  `idverifico` int DEFAULT NULL,
  `caja_base` double(22,2) DEFAULT NULL,
  `efectivo` double(22,2) DEFAULT NULL,
  `tarjetas` double(22,2) DEFAULT NULL,
  `transferencias` double(22,2) DEFAULT NULL,
  `total_facturado` double(22,2) DEFAULT NULL,
  `diferencia` double(22,2) DEFAULT NULL,
  `comentario` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `fecha_init` date DEFAULT NULL,
  `fecha_close` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `estado` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `idcategoria` int NOT NULL,
  `descripcion` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria_precios`
--

CREATE TABLE `categoria_precios` (
  `idCategoriaPrecio` int NOT NULL,
  `descripcion` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `factor` double(22,2) DEFAULT NULL,
  `creado_por` int DEFAULT NULL,
  `modificado_por` int DEFAULT NULL,
  `creado_el` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `ultima_modificacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `idcliente` int NOT NULL,
  `nombre` varchar(75) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cedula` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `telefono` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `direccion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `creado_el` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `creado_por` int DEFAULT NULL,
  `ultima_modificacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `modificado_por` int DEFAULT NULL,
  `estado` int DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consecutivos`
--

CREATE TABLE `consecutivos` (
  `idconsecutivos` int NOT NULL,
  `fac` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `descuentos`
--

CREATE TABLE `descuentos` (
  `iddescuento` int NOT NULL,
  `descripcion` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `descuento` double DEFAULT NULL,
  `showFac` int DEFAULT NULL COMMENT 'Mostrar en facturacion',
  `creado_por` int DEFAULT NULL,
  `creado_el` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `modificado_por` int DEFAULT NULL,
  `modificado_el` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `activo` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_devoluciones`
--

CREATE TABLE `detalles_devoluciones` (
  `idDetalleDevolucion` int NOT NULL,
  `idDevolucion` int NOT NULL,
  `idProducto` int NOT NULL,
  `cantidad` int NOT NULL,
  `monto` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_factura`
--

CREATE TABLE `detalle_factura` (
  `iddetalle_factura` bigint NOT NULL,
  `idfactura` bigint DEFAULT NULL,
  `idproducto` int DEFAULT NULL,
  `cantidad` int DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `descuento` int DEFAULT NULL,
  `iva` int DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `fecha` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `devoluciones`
--

CREATE TABLE `devoluciones` (
  `idDevolucion` int NOT NULL,
  `fac` bigint NOT NULL,
  `fechaDevolucion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fechaMaxReclamo` date NOT NULL,
  `idUsuario` int NOT NULL DEFAULT '0',
  `total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `Saldo` decimal(10,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas`
--

CREATE TABLE `facturas` (
  `idfactura` bigint NOT NULL,
  `idcaja` int DEFAULT NULL,
  `consecutivo` bigint DEFAULT NULL,
  `idusuario` int DEFAULT NULL,
  `idcliente` int DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `formatDate` date DEFAULT NULL,
  `impuesto` decimal(10,2) DEFAULT NULL,
  `descuento` decimal(10,2) DEFAULT NULL,
  `extra_descuento` double DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `saldo` decimal(10,2) DEFAULT NULL,
  `saldo_ref` bigint DEFAULT NULL,
  `monto_envio` decimal(10,2) DEFAULT NULL,
  `tipo` int DEFAULT NULL COMMENT 'local 1, envio 2, apartado 3',
  `efectivo` int DEFAULT NULL,
  `tarjeta` int DEFAULT NULL,
  `transferencia` int DEFAULT NULL,
  `banco_transferencia` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `referencia_transferencia` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `monto_transferencia` double(10,2) DEFAULT NULL,
  `numero_tarjeta` int DEFAULT NULL,
  `monto_tarjeta` double(10,2) DEFAULT NULL,
  `monto_efectivo` double(10,2) DEFAULT NULL,
  `multipago` int DEFAULT NULL,
  `multipago_string` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `multipago_total` double DEFAULT NULL,
  `estado` int DEFAULT NULL COMMENT '0-pendiente, 1-completado, 2-cancelado',
  `comentario` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gastos`
--

CREATE TABLE `gastos` (
  `idgastos` int NOT NULL,
  `gastos` varchar(4000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `efectivo` double(22,2) UNSIGNED DEFAULT '0.00',
  `tarjeta` double(22,2) UNSIGNED DEFAULT '0.00',
  `transferencia` double(22,2) UNSIGNED DEFAULT '0.00',
  `total` double(22,2) UNSIGNED DEFAULT NULL,
  `modificado_por` int DEFAULT NULL,
  `modificado_el` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_ingresos` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `generalinfo`
--

CREATE TABLE `generalinfo` (
  `idgeneral` int NOT NULL DEFAULT '0',
  `nombre_local` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `razon_social` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cedula_juridica` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `telefono` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `direccion` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `correo_info` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `correo_venta` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mensaje_footer_fac` varchar(65) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mensaje_restricciones` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `url_logo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mensaje_footer_apartado` varchar(65) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `idclienteGenerico` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historico_ingresos`
--

CREATE TABLE `historico_ingresos` (
  `idhistorico_ingresos` int NOT NULL,
  `cant` int DEFAULT NULL,
  `precio` int DEFAULT NULL,
  `update` int DEFAULT NULL,
  `comentario` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `idusuario` int DEFAULT NULL,
  `idproducto` int DEFAULT NULL,
  `creado_el` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `log`
--

CREATE TABLE `log` (
  `idlog` int NOT NULL,
  `accion` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `modulo` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `detalle` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `datos` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `idusuario` int DEFAULT NULL,
  `creado_el` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ofertas`
--

CREATE TABLE `ofertas` (
  `idOferta` int NOT NULL,
  `nombreOferta` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `cantidad` int NOT NULL,
  `productoOrlista` int NOT NULL,
  `descuento` int NOT NULL,
  `unica` int NOT NULL,
  `productos` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `createAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updateAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos_por_factura`
--

CREATE TABLE `pagos_por_factura` (
  `idpago` int NOT NULL,
  `idfactura` int DEFAULT NULL,
  `idtipo_venta` int DEFAULT NULL,
  `monto` double(22,2) DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `idusuario` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `idproducto` int NOT NULL,
  `descripcion` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `descripcion_short` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `marca` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `estilo` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `idcategoria` int DEFAULT NULL,
  `idtalla` int DEFAULT NULL,
  `codigo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `iva` int DEFAULT '0',
  `activado_iva` int DEFAULT '0',
  `precio_costo` double(22,2) DEFAULT '0.00',
  `precio_venta` double(22,2) DEFAULT '0.00',
  `precio_unitario` double(22,2) DEFAULT '0.00',
  `precio_sugerido` double(22,2) DEFAULT '0.00',
  `iddescuento` int DEFAULT '0',
  `idOferta` int DEFAULT '0',
  `categoriaPrecio` int DEFAULT NULL,
  `min_stock` int DEFAULT '0',
  `stock` int DEFAULT '0',
  `image_url` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `creado_el` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `creado_por` int DEFAULT NULL,
  `ultima_modificacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modificado_por` int DEFAULT NULL,
  `estado` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recibos`
--

CREATE TABLE `recibos` (
  `idrecibo` int NOT NULL,
  `idusuario` int DEFAULT NULL,
  `idfactura` bigint DEFAULT NULL,
  `idcaja` int DEFAULT NULL,
  `abono` double(22,2) DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `fechaFormat` date DEFAULT NULL,
  `monto_transferencia` double(22,2) DEFAULT NULL,
  `monto_tarjeta` double(22,2) DEFAULT NULL,
  `monto_efectivo` double(22,2) DEFAULT NULL,
  `numero_tarjeta` int DEFAULT NULL,
  `banco_transferencia` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `referencia_transferencia` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `efectivo` int DEFAULT NULL,
  `tarjeta` int DEFAULT NULL,
  `transferencia` int DEFAULT NULL,
  `multipago` int DEFAULT NULL,
  `multipago_total` double DEFAULT NULL,
  `multipago_string` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `idrol` int NOT NULL,
  `rol` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `descripcion` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `permisos` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `creado_el` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `creado_por` int DEFAULT NULL,
  `ultima_modificacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `modificado_por` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sucursal`
--

CREATE TABLE `sucursal` (
  `idsucursal` int NOT NULL,
  `descripcion` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ubicacion` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `telefono` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `creado_el` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `creado_por` int DEFAULT NULL,
  `modificado_por` int DEFAULT NULL,
  `ultima_modificacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `estado` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tallas`
--

CREATE TABLE `tallas` (
  `idtallas` int NOT NULL,
  `talla` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `descripcion` varchar(70) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_venta`
--

CREATE TABLE `tipo_venta` (
  `idtipo_venta` int NOT NULL,
  `tipo_venta` int DEFAULT NULL,
  `descripcion` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transacciones_saldos`
--

CREATE TABLE `transacciones_saldos` (
  `idtransaccion` int NOT NULL,
  `fac` bigint DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `ref` bigint DEFAULT NULL,
  `saldoUsado` decimal(10,2) DEFAULT NULL,
  `saldoPendiente` decimal(10,2) DEFAULT NULL,
  `idusuario` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `traslados`
--

CREATE TABLE `traslados` (
  `idTraslado` int NOT NULL,
  `uniqId` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `tiendaOrigen` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `tiendaTraslado` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `dbOrigen` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `dbTraslado` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `productos` text COLLATE utf8mb4_general_ci,
  `comentario` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `idUserOrigen` int DEFAULT NULL,
  `idUserTraslado` int DEFAULT NULL,
  `createAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updateAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `aceptado` int NOT NULL,
  `estado` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idusuario` int NOT NULL,
  `usuario` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `email` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `telefono` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `direccion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `estado` int DEFAULT NULL COMMENT '0: inhailitado 1: habilitado 2:cambio de password',
  `rol` int DEFAULT NULL,
  `identificador` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `apartado`
--
ALTER TABLE `apartado`
  ADD PRIMARY KEY (`idapartado`),
  ADD KEY `idventa` (`idventa`),
  ADD KEY `FK_apartado_cliente` (`idcliente`),
  ADD KEY `FK_apartado_usuario` (`idusuario`);

--
-- Indices de la tabla `cajas`
--
ALTER TABLE `cajas`
  ADD PRIMARY KEY (`idcaja`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`idcategoria`);

--
-- Indices de la tabla `categoria_precios`
--
ALTER TABLE `categoria_precios`
  ADD PRIMARY KEY (`idCategoriaPrecio`) USING BTREE;

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`idcliente`);

--
-- Indices de la tabla `consecutivos`
--
ALTER TABLE `consecutivos`
  ADD PRIMARY KEY (`idconsecutivos`);

--
-- Indices de la tabla `descuentos`
--
ALTER TABLE `descuentos`
  ADD PRIMARY KEY (`iddescuento`);

--
-- Indices de la tabla `detalles_devoluciones`
--
ALTER TABLE `detalles_devoluciones`
  ADD PRIMARY KEY (`idDetalleDevolucion`);

--
-- Indices de la tabla `detalle_factura`
--
ALTER TABLE `detalle_factura`
  ADD PRIMARY KEY (`iddetalle_factura`) USING BTREE,
  ADD KEY `FK_detalle_venta_venta` (`idfactura`) USING BTREE;

--
-- Indices de la tabla `devoluciones`
--
ALTER TABLE `devoluciones`
  ADD PRIMARY KEY (`idDevolucion`),
  ADD UNIQUE KEY `fac` (`fac`);

--
-- Indices de la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD PRIMARY KEY (`idfactura`) USING BTREE,
  ADD UNIQUE KEY `consecutivo` (`consecutivo`),
  ADD KEY `FK_venta_usuario` (`idusuario`);

--
-- Indices de la tabla `gastos`
--
ALTER TABLE `gastos`
  ADD PRIMARY KEY (`idgastos`);

--
-- Indices de la tabla `generalinfo`
--
ALTER TABLE `generalinfo`
  ADD PRIMARY KEY (`idgeneral`);

--
-- Indices de la tabla `historico_ingresos`
--
ALTER TABLE `historico_ingresos`
  ADD PRIMARY KEY (`idhistorico_ingresos`),
  ADD KEY `idusuario` (`idusuario`),
  ADD KEY `idproducto` (`idproducto`);

--
-- Indices de la tabla `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`idlog`),
  ADD KEY `FK_log_usuario` (`idusuario`);

--
-- Indices de la tabla `ofertas`
--
ALTER TABLE `ofertas`
  ADD PRIMARY KEY (`idOferta`);

--
-- Indices de la tabla `pagos_por_factura`
--
ALTER TABLE `pagos_por_factura`
  ADD PRIMARY KEY (`idpago`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`idproducto`),
  ADD UNIQUE KEY `codigo` (`codigo`),
  ADD KEY `FK_producto_categoria_precios` (`categoriaPrecio`);

--
-- Indices de la tabla `recibos`
--
ALTER TABLE `recibos`
  ADD PRIMARY KEY (`idrecibo`) USING BTREE;

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`idrol`);

--
-- Indices de la tabla `sucursal`
--
ALTER TABLE `sucursal`
  ADD PRIMARY KEY (`idsucursal`),
  ADD KEY `FK_sucursal_usuario` (`creado_por`),
  ADD KEY `FK_sucursal_usuario_2` (`modificado_por`);

--
-- Indices de la tabla `tallas`
--
ALTER TABLE `tallas`
  ADD PRIMARY KEY (`idtallas`);

--
-- Indices de la tabla `tipo_venta`
--
ALTER TABLE `tipo_venta`
  ADD PRIMARY KEY (`idtipo_venta`);

--
-- Indices de la tabla `transacciones_saldos`
--
ALTER TABLE `transacciones_saldos`
  ADD PRIMARY KEY (`idtransaccion`);

--
-- Indices de la tabla `traslados`
--
ALTER TABLE `traslados`
  ADD PRIMARY KEY (`idTraslado`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idusuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `apartado`
--
ALTER TABLE `apartado`
  MODIFY `idapartado` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cajas`
--
ALTER TABLE `cajas`
  MODIFY `idcaja` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `idcategoria` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `categoria_precios`
--
ALTER TABLE `categoria_precios`
  MODIFY `idCategoriaPrecio` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `idcliente` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `consecutivos`
--
ALTER TABLE `consecutivos`
  MODIFY `idconsecutivos` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `descuentos`
--
ALTER TABLE `descuentos`
  MODIFY `iddescuento` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalles_devoluciones`
--
ALTER TABLE `detalles_devoluciones`
  MODIFY `idDetalleDevolucion` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_factura`
--
ALTER TABLE `detalle_factura`
  MODIFY `iddetalle_factura` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `devoluciones`
--
ALTER TABLE `devoluciones`
  MODIFY `idDevolucion` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `facturas`
--
ALTER TABLE `facturas`
  MODIFY `idfactura` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `gastos`
--
ALTER TABLE `gastos`
  MODIFY `idgastos` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `historico_ingresos`
--
ALTER TABLE `historico_ingresos`
  MODIFY `idhistorico_ingresos` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `log`
--
ALTER TABLE `log`
  MODIFY `idlog` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ofertas`
--
ALTER TABLE `ofertas`
  MODIFY `idOferta` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pagos_por_factura`
--
ALTER TABLE `pagos_por_factura`
  MODIFY `idpago` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `idproducto` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `recibos`
--
ALTER TABLE `recibos`
  MODIFY `idrecibo` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `idrol` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `sucursal`
--
ALTER TABLE `sucursal`
  MODIFY `idsucursal` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tallas`
--
ALTER TABLE `tallas`
  MODIFY `idtallas` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipo_venta`
--
ALTER TABLE `tipo_venta`
  MODIFY `idtipo_venta` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `transacciones_saldos`
--
ALTER TABLE `transacciones_saldos`
  MODIFY `idtransaccion` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `traslados`
--
ALTER TABLE `traslados`
  MODIFY `idTraslado` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idusuario` int NOT NULL AUTO_INCREMENT;

DELIMITER $$
--
-- Eventos
--
CREATE DEFINER=`root`@`localhost` EVENT `Disable_Products` ON SCHEDULE EVERY 1 DAY STARTS '2021-05-16 22:40:00' ON COMPLETION PRESERVE ENABLE DO UPDATE producto AS p SET p.estado = 0
WHERE p.stock <= 0 AND (DATE((SELECT MAX(f.fecha) AS maxDate FROM detalle_factura f WHERE f.idproducto = p.idproducto)) < DATE(NOW() - INTERVAL 2 MONTH)) AND p.estado = 1$$

CREATE DEFINER=`root`@`localhost` EVENT `ONLY_FULL_GROUP` ON SCHEDULE EVERY 1 DAY STARTS '2021-07-27 22:41:57' ON COMPLETION PRESERVE ENABLE DO SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))$$

DELIMITER ;
COMMIT;
