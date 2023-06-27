<?php
include_once __DIR__ . "\..\db\AccesoDatos.php";

class CriptoMoneda
{
	public $id;
	public $precio;
	public $nombre;
	public $foto;
	public $nacionalidad;

	public function CrearCripto()
	{
		$objAccesoDatos = AccesoDatos::ObtenerInstancia();
		$req = $objAccesoDatos->PrepararConsulta("INSERT INTO criptomonedas (precio, nombre, foto, nacionalidad) VALUES (:precio, :nombre, :foto, :nacionalidad)");

		$req->bindValue(':precio', (string)$this->precio, PDO::PARAM_STR);
		$req->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
		$req->bindValue(':foto', $this->foto, PDO::PARAM_STR);
		$req->bindValue(':nacionalidad', $this->nacionalidad, PDO::PARAM_STR);
		$req->execute();

		return $objAccesoDatos->ObtenerUltimoId();
	}

	public static function TraerTodas()
	{
		$objAccesoDatos = AccesoDatos::ObtenerInstancia();
		$req = $objAccesoDatos->PrepararConsulta("SELECT * FROM criptomonedas");
		$req->execute();
		return $req->fetchAll(PDO::FETCH_CLASS, 'CriptoMoneda');
	}

	public static function TraerPorNombre($nombre)
	{
		$objAccesoDatos = AccesoDatos::ObtenerInstancia();
		$req = $objAccesoDatos->PrepararConsulta("SELECT * FROM criptomonedas WHERE nombre LIKE :nombre");
		$req->bindValue(':nombre', $nombre);
		$req->execute();
		return $req->fetchAll(PDO::FETCH_CLASS, 'CriptoMoneda');
	}

	public static function TraerPorNacionalidad($nacionalidad)
	{
		$objAccesoDatos = AccesoDatos::ObtenerInstancia();
		$req = $objAccesoDatos->PrepararConsulta("SELECT * FROM criptomonedas WHERE nacionalidad LIKE :nacionalidad");
		$req->bindValue(':nacionalidad', $nacionalidad);
		$req->execute();
		return $req->fetchAll(PDO::FETCH_CLASS, 'CriptoMoneda');
	}

	public static function TraerPorId($id)
	{
		$objAccesoDatos = AccesoDatos::ObtenerInstancia();
		$req = $objAccesoDatos->PrepararConsulta("SELECT * FROM criptomonedas WHERE id=:id");
		$req->bindValue(':id', $id);
		$req->execute();
		return $req->fetchAll(PDO::FETCH_CLASS, 'CriptoMoneda');
	}

	public static function BorrarUna($id)
	{
		$objAccesoDatos = AccesoDatos::ObtenerInstancia();
		
		$req = $objAccesoDatos->PrepararConsulta("DELETE FROM criptomonedas WHERE id=:id");
		$req->bindValue(':id', $id);
		$req->execute();
		
		return $objAccesoDatos->ObtenerUltimoId();
	}

	public function Modificar($precio, $nombre, $nacionalidad)
	{
		$objAccesoDatos = AccesoDatos::ObtenerInstancia();
		
		$req = $objAccesoDatos->PrepararConsulta("UPDATE criptomonedas SET precio=:precio, nombre=:nombre, nacionalidad=:nacionalidad WHERE id=:id");
		$req->bindValue(':id', $this->id, PDO::PARAM_INT);
		$req->bindValue(':precio', (string)$precio, PDO::PARAM_STR);
		$req->bindValue(':nombre', $nombre, PDO::PARAM_STR);
		$req->bindValue(':nacionalidad', $nacionalidad, PDO::PARAM_STR);
		$req->execute();
		
		return $objAccesoDatos->ObtenerUltimoId();
	}

	public static function DbToCsv($rutaArchivo)
	{
		$monedas = self::TraerTodas();

		if (!empty($monedas)) {
			$refArchivo = fopen($rutaArchivo, "w");
			if ($refArchivo) {
				foreach ($monedas as $moneda) {
					$attr = get_object_vars($moneda);
					$strCoin = implode(',', $attr) . PHP_EOL;

					fwrite($refArchivo, $strCoin);
				}
				return fclose($refArchivo);
			}
		}

		return false;
	}
}