<?php

include_once __DIR__ . "\..\db\AccesoDatos.php";

class Log
{
	public $idUsuario;
	public $idCripto;
	public $accion;
	public $fecha_accion;

	public function CrearLog()
	{
		$objAccesoDatos = AccesoDatos::ObtenerInstancia();
		$req = $objAccesoDatos->PrepararConsulta("INSERT INTO logs(idUsuario, idCripto, accion, fecha_accion) VALUES (:idUsuario, :idCripto, :accion, :fecha_accion)");
		$req->bindValue(':idUsuario', $this->idUsuario, PDO::PARAM_INT);
		$req->bindValue(':idCripto', $this->idCripto, PDO::PARAM_INT);
		$req->bindValue(':accion', $this->accion, PDO::PARAM_STR);
		$req->bindValue(':fecha_accion', $this->fecha_accion, PDO::PARAM_STR);
		$req->execute();

		return $objAccesoDatos->ObtenerUltimoId();
	}
}