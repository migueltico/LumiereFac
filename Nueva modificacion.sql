ALTER TABLE producto ADD COLUMN isNew BOOLEAN NOT NULL DEFAULT '0'

DELIMITER //

DROP TRIGGER IF EXISTS before_update_producto;

CREATE TRIGGER before_update_producto
BEFORE UPDATE ON producto FOR EACH ROW
BEGIN
    DECLARE usuario_rol VARCHAR(50);
    DECLARE tiene_permiso BOOLEAN;
    DECLARE mensaje_error VARCHAR(255);
    -- Obtener el rol del usuario que está realizando la modificación
    SELECT rol INTO usuario_rol FROM usuario WHERE idusuario = NEW.modificado_por;
    
    -- Verificar si el rol tiene el permiso 'modificar_precio'
    SET tiene_permiso = EXISTS (SELECT * FROM rol WHERE permisos LIKE '%modificar_precio%' AND idrol = usuario_rol);
    -- Verificar si el cambio incluye modificar el precio_venta y isNew es 1
    IF OLD.isNew = 0 AND NEW.precio_venta <> OLD.precio_venta AND NOT tiene_permiso THEN
        -- Construir el mensaje de error con los valores deseados
        SET mensaje_error = 'No tiene permisos para modificar el precio_venta de un producto con el precio_venta ya establecido';
        -- Lanzar una excepción para evitar la actualización
        SIGNAL SQLSTATE 'ER001' SET MESSAGE_TEXT = mensaje_error;   
		  
		  ELSE
			IF NEW.precio_venta <> OLD.precio_venta THEN
		  		SET NEW.isNew = 0;   
			END IF;
    END IF;


END;
//
DELIMITER ;