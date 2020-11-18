<?php

namespace config;

use PDO;
use config\config;

class conexion
{

	private $con;
	private $statement;
	public function __construct()
	{
		try {
			//$pdo = new PDO("mysql:host=". HOST . ";dbname=". DB . ";",USER,PASS);
			$this->con = new \PDO("mysql:host=" . DB_HOST . ";dbname=" . $GLOBALS["DB_NAME"][$_SESSION['db']] . ";", $GLOBALS["DB_USER"], $GLOBALS["DB_PASS"], array(PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
		} catch (\PDOException $e) {
			echo 'Error al conectarse con la base de datos: ' . $e->getMessage();
			exit;
		}
	}
	function disconnect()
	{
		// $this->statement->closeCursor();
		$this->statement = null;
		$this->con = null;
	}
	public function Sqlforeach($sql, $datos)
	{
		try {
			$this->statement = $this->con->prepare($sql);
			//$isOk = $this->con->beginTransaction();
			foreach ($datos as $items) {
				# code...
				$this->statement->execute($items);
				if (!$this->statement) {
					//$this->con->rollBack();
					$this->disconnect();
					return  array('estado' => false, 'generalError' => false, 'rollback' => true,  'error' => $this->statement->errorCode(), 'errorMsg' => $this->statement->errorInfo());
				}
			}

			$estado = array('estado' => $this->statement, 'error' => $this->statement->errorCode(), 'errorMsg' => $this->statement->errorInfo());
			$return = $estado;
			$this->disconnect();
			return $return;
		} catch (\PDOException $e) {
			$this->disconnect();
			return $e;
		}
	}
	public function Multitransaction($sql, $datos)
	{

		try {
			$this->statement = $this->con->prepare($sql);
			//$isOk = $this->con->beginTransaction();
			$this->statement->execute($datos);
			if (!$this->statement) {
				//$this->con->rollBack();
				$this->disconnect();
				return  array('estado' => false, 'generalError' => false, 'rollback' => true,  'error' => $this->statement->errorCode(), 'errorMsg' => $this->statement->errorInfo());
			}
			$row = $this->statement->fetch(PDO::FETCH_ASSOC);
			$cuenta = $this->statement->rowCount();
			$estado = array("rows" => $cuenta, "data" => $row, "SQL" => $this->statement, 'estado' => true, 'generalError' => false, 'rollback' => false,  'error' => $this->statement->errorCode(), 'errorMsg' => $this->statement->errorInfo());
			if ($estado['error'] == "00000" && $estado['estado'] == true) {
				//$this->con->commit();
				$this->disconnect();
				return $estado;
			} else {
				//$this->con->rollBack();
				$this->disconnect();
				return  array("rows" => 0, 'estado' => false, 'generalError' => false, 'rollback' => true,  'error' => $this->statement->errorCode(), 'errorMsg' => $this->statement->errorInfo());
			}
		} catch (\PDOException $e) {
			//$this->con->rollBack();
			$this->disconnect();
			return  array('data' => json_encode($datos), 'sql' => $sql, "rows" => 0, 'estado' => false, 'generalError' => $e, 'rollback' => true,);
		}
	}
	/**
	 * SIMPLE QUERY, NO RETORNA DATOS, SE PASAN LOS DATOS POR VARIABLE EN EL EXECUTE
	 *
	 * @param [type] $sql
	 * @param [type] $datos
	 * @return void
	 */
	public function SQ($sql, $datos)
	{
		try {
			$this->statement = $this->con->prepare($sql);
			$this->statement->execute($datos);
			if (!$this->statement) {
				$stm = false;
			} else {
				$stm = true;
			}
			$estado = array('estado' => $stm, 'error' => $this->statement->errorCode(), 'errorMsg' => $this->statement->errorInfo());
			$return = $estado;
			return $return;
		} catch (\PDOException $e) {
			return $e;
		}
	}

	/**
	 * SIMPLE QUERY, NO RETORNA DATOS, SE PASAN LOS DATOS POR VARIABLE EN EL EXECUTE
	 *
	 * @param [type] $sql
	 * @param [type] $datos
	 * @return void
	 */
	public function SPCALLNR($sql, $datos)
	{
		try {
			$this->statement = $this->con->prepare($sql);
			$this->statement->execute($datos);
			if (!$this->statement) {
				$stm = false;
			} else {
				$stm = true;
			}
			$estado = array('estado' => $stm, 'error' => $this->statement->errorCode(), 'errorMsg' => $this->statement->errorInfo());
			$return = $estado;
			return $return;
		} catch (\PDOException $e) {

			$this->disconnect();
			return $e;
		}
	}
	/**
	 * SIMPLE QUERY, Si RETORNA DATOS,NO SE PASAN LOS DATOS POR VARIABLE EN EL EXECUTE
	 *
	 * @param [type] $sql
	 * @return void
	 */
	public function SQND($sql)
	{
		try {
			$this->statement = $this->con->prepare($sql);
			$this->statement->execute();
			if (!$this->statement) {
				$estado = array('estado' => false, 'error' => $this->statement->errorCode(), 'errorMsg' => $this->statement->errorInfo());
				$return = $estado;
				return $estado;
			}
			$row = $this->statement->fetchAll(PDO::FETCH_ASSOC);
			$cuenta = $this->statement->rowCount();
			//return $row ;
			return array("rows" => $cuenta, "data" => $row, "SQL" => $this->statement, 'estado' => false, 'error' => $this->statement->errorCode(), 'errorMsg' => $this->statement->errorInfo());
		} catch (\PDOException $e) {
			$this->disconnect();
			return $e;
		}
	}
	/**
	 * SIMPLE QUERY, Si RETORNA DATOS,NO SE PASAN LOS DATOS POR VARIABLE EN EL EXECUTE
	 *
	 * @param [type] $sql
	 * @return void
	 */
	public function SPCALL($sql)
	{
		try {
			$this->statement = $this->con->prepare($sql);
			$this->statement->execute();
			if (!$this->statement) {
				$estado = array('estado' => false, 'error' => $this->statement->errorCode(), 'errorMsg' => $this->statement->errorInfo());
				$return = $estado;
				return $estado;
			}
			$row = $this->statement->fetchAll(PDO::FETCH_ASSOC);
			$cuenta = $this->statement->rowCount();
			//return $row ;
			$estado = array("rows" => $cuenta, "data" => $row, "SQL" => $this->statement, 'estado' => true, 'error' => $this->statement->errorCode(), 'errorMsg' => $this->statement->errorInfo());
			$this->disconnect();
			return $estado;
		} catch (\PDOException $e) {
			$this->disconnect();
			return $e;
		}
	}
	/**
	 * SP SIMPLE QUERY, Si RETORNA DATOS,NO SE PASAN LOS DATOS POR VARIABLE EN EL EXECUTE
	 *
	 * @param [type] $sql
	 * @return void
	 */
	public function TRANSACTION_ONE($sql)
	{

		try {

			$this->statement = $this->con->prepare($sql);
			$this->statement->execute();
			if (!$this->statement) {
				$estado = array('estado' => false, 'error' => $this->statement->errorCode(), 'errorMsg' => $this->statement->errorInfo());
				$return = $estado;
				return $estado;
			}
			//$this->statement->commit();
			$row = $this->statement->fetchAll(PDO::FETCH_ASSOC);
			$cuenta = $this->statement->rowCount();
			//return $row ;
			$estado = array("rows" => $cuenta, "data" => $row, "SQL" => $this->statement, 'estado' => true, 'error' => $this->statement->errorCode(), 'errorMsg' => $this->statement->errorInfo());
			return $estado;
		} catch (\PDOException $e) {
			$this->disconnect();
			//$this->statement->rollBack();
			echo "Fallo: " . $e->getMessage();
		}
	}
	/**
	 * SP SIMPLE QUERY, Si RETORNA DATOS,NO SE PASAN LOS DATOS POR VARIABLE EN EL EXECUTE
	 *
	 * @param [type] $sql
	 * @return void
	 */
	public function TRANSACTION_ALL($sql)
	{
		try {
			$this->statement = $this->con->prepare($sql);
			$this->statement->execute();
			if (!$this->statement) {
				$estado = array('estado' => false, 'error' => $this->statement->errorCode(), 'errorMsg' => $this->statement->errorInfo());
				$return = $estado;
				return $estado;
			} else {
				$row = $this->statement->fetchAll(PDO::FETCH_ASSOC);
				$cuenta = $this->statement->rowCount();
				//return $row ;
				$estado = array("rows" => $cuenta, "data" => $row, "SQL" => $this->statement, 'estado' => true, 'error' => $this->statement->errorCode(), 'errorMsg' => $this->statement->errorInfo());
				return $estado;
			}
		} catch (\PDOException $e) {
			$this->disconnect();
			return $e;
		}
	}
	/**
	 * SIMPLE RETURN QUERY, SI RETORNA DATOS, LA PRIMERA FILA ENCONTRADA, SE PASAN LOS DATOS POR VARIABLE EN EL EXECUTE
	 *
	 * @param [type] $sql
	 * @param [type] $datos
	 * @return void
	 */
	public function SRQ($sql, $datos)
	{

		$this->statement = $this->con->prepare($sql);
		$this->statement->execute($datos);
		if (!$this->statement) {
			$estado = array('estado' => false, 'error' => $this->statement->errorCode(), 'errorMsg' => $this->statement->errorInfo());
			return $estado;
		}
		$row = $this->statement->fetch(PDO::FETCH_ASSOC);
		$cuenta = $this->statement->rowCount();
		//return $row ;
		return array("rows" => $cuenta, "data" => $row,  'estado' => true, 'error' => $this->statement->errorCode(), 'errorMsg' => $this->statement->errorInfo());
		//return array("rows" => $cuenta, "data" => $row);
	}
	/**
	 * SIMPLE RETURN QUERY, SI RETORNA DATOS, LA PRIMERA FILA ENCONTRADA
	 *
	 * @param [type] $sql
	 * @param [type] $datos
	 * @return void
	 */
	public function SQR_ONEROW($sql)
	{
		try {
			$this->statement = $this->con->prepare($sql);
			$this->statement->execute();
			if (!$this->statement) {
				$estado = array('estado' => false, 'error' => $this->statement->errorCode(), 'errorMsg' => $this->statement->errorInfo());
				return $estado;
			}
			$row = $this->statement->fetch(PDO::FETCH_ASSOC);
			$cuenta = $this->statement->rowCount();
			$this->statement->closeCursor();
			//return $row ;
			return array("rows" => $cuenta, "data" => $row,  'estado' => true, 'error' => $this->statement->errorCode(), 'errorMsg' => $this->statement->errorInfo());
			//return array("rows" => $cuenta, "data" => $row);
		} catch (\PDOException $e) {
			$this->disconnect();
			return $e;
		}
	}
	/**
	 * SIMPLE RETURN QUERY, SI RETORNA DATOS, LA PRIMERA FILA ENCONTRADA, SE PASAN LOS DATOS POR VARIABLE EN EL EXECUTE
	 *
	 * @param [type] $sql
	 * @param [type] $datos
	 * @return void
	 */
	public function SPCALLR($sql, $datos)
	{

		$this->statement = $this->con->prepare($sql);
		$this->statement->execute($datos);
		if (!$this->statement) {
			$estado = array('estado' => false, 'error' => $this->statement->errorCode(), 'errorMsg' => $this->statement->errorInfo());
			return $estado;
		}
		$row = $this->statement->fetch(PDO::FETCH_ASSOC);
		$cuenta = $this->statement->rowCount();
		//return $row ;
		return array("rows" => $cuenta, "data" => $row, "SQL" => $this->statement);
	}
	/**
	 * MULTIPLE RETURN QUERY, SI RETORNA DATOS, TODAS FILA ENCONTRADA
	 *
	 * @param [type] $sql
	 * @return void
	 */
	public function MRQ($sql)
	{
		try {
			$this->statement = $this->con->prepare($sql);
			$this->statement->execute();
			$row = $this->statement->fetchAll(PDO::FETCH_ASSOC);
			$cuenta = $this->statement->rowCount();
			if ($this->statement) {
				return $row;
			}
		} catch (\PDOException $e) {
			$this->disconnect();
			return $e;
		}
	}
	/**
	 * MULTIPLE RETURN QUERY CON DATOS, SI RETORNA DATOS, TODAS FILA ENCONTRADA
	 *
	 * @param [type] $sql
	 * @param [type] $data
	 * @return void
	 */
	public function MRQD($sql, $data)
	{
		try {
			$this->statement = $this->con->prepare($sql);
			$this->statement->execute($data);
			$row = $this->statement->fetchAll(PDO::FETCH_ASSOC);
			$cuenta = $this->statement->rowCount();
			if ($this->statement) {
				return $row;
			}
		} catch (\PDOException $e) {
			$this->disconnect();
			return $e;
		}
	}
}
