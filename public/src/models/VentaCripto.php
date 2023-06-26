<?php
/* 6-(POST)Alta de ventaCripto (id,fecha,cantidad…y demás datos que crea necesarios) además de tener
una imagen (jpg , jpeg ,png)asociada a la venta que será nombrada por  ->cualquier usuario
registrado(JWT) */

include_once __DIR__ . "\..\db\AccesoDatos.php";

class VentaCripto extends CriptoController
{
	public $id;
	public $fecha;
	public $cant;
	public $idCripto;
	public $idCliente;
	public $foto;

	public function NuevaVenta()
	{
		$objAccesoDatos = AccesoDatos::ObtenerInstancia();
		$req = $objAccesoDatos->PrepararConsulta("INSERT INTO ventas(fecha, cantidad, idCripto, idCliente, foto) VALUES (:fecha, :cant, :idCripto, :idCliente, :foto)");
		$req->bindValue(':fecha', $this->fecha, PDO::PARAM_STR);
		$req->bindValue(':cant', (string)$this->cant, PDO::PARAM_STR);
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
}