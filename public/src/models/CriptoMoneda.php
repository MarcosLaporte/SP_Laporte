<?php
include_once __DIR__ . "\..\db\AccesoDatos.php";

class CriptoMoneda
{
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
}