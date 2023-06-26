<?php
/* 6-(POST)Alta de ventaCripto (id,fecha,cantidad…y demás datos que crea necesarios) además de tener
una imagen (jpg , jpeg ,png)asociada a la venta que será nombrada por  ->cualquier usuario
registrado(JWT) */

include_once __DIR__ . "\..\db\AccesoDatos.php";

class VentaCripto extends CriptoController
{
	public $id;
	public $fecha;
	public $cantidad;
	public $idCripto;
	public $idCliente;
	public $foto;

	public function NuevaVenta()
	{
		$objAccesoDatos = AccesoDatos::ObtenerInstancia();
		$req = $objAccesoDatos->PrepararConsulta("INSERT INTO ventas(fecha, cantidad, idCripto, idCliente, foto) VALUES (:fecha, :cantidad, :idCripto, :idCliente, :foto)");
		$req->bindValue(':fecha', $this->fecha, PDO::PARAM_STR);
		$req->bindValue(':cantidad', (string) $this->cantidad, PDO::PARAM_STR);
		$req->bindValue(':idCripto', $this->idCripto, PDO::PARAM_INT);
		$req->bindValue(':idCliente', $this->idCliente, PDO::PARAM_INT);
		$req->bindValue(':foto', $this->foto, PDO::PARAM_STR);
		$req->execute();

		return $objAccesoDatos->ObtenerUltimoId();
	}

	public static function TraerTodas()
	{
		$objAccesoDatos = AccesoDatos::ObtenerInstancia();
		$req = $objAccesoDatos->PrepararConsulta("SELECT * FROM ventas");
		$req->execute();
		return $req->fetchAll(PDO::FETCH_CLASS, 'VentaCripto');
	}

	public static function TraerEntreFechasNacionalidad($inicio, $final, $nacionalidad)
	{
		$objAccesoDatos = AccesoDatos::ObtenerInstancia();
		$req = $objAccesoDatos->PrepararConsulta(
			"SELECT * FROM ventas " .
			"JOIN criptomonedas ON ventas.idCripto = criptomonedas.id " .
			"WHERE ventas.fecha BETWEEN :inicio AND :final " .
			"AND criptomonedas.nacionalidad = :nacionalidad"
		);
		$req->bindValue(':inicio', $inicio, PDO::PARAM_STR);
		$req->bindValue(':final', $final, PDO::PARAM_STR);
		$req->bindValue(':nacionalidad', $nacionalidad, PDO::PARAM_STR);
		$req->execute();
		return $req->fetchAll(PDO::FETCH_CLASS, 'VentaCripto');
	}
}