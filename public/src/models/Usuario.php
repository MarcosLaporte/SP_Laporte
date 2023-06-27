<?php
include_once __DIR__ . "\..\db\AccesoDatos.php";

define('TIPO_ADMIN', 0);
define('TIPO_CLIENTE', 1);
class Usuario
{
	public $id;
	public $mail;
	public $clave;
	public $tipo;

	public function CrearUsuario()
	{
		$objAccesoDatos = AccesoDatos::ObtenerInstancia();
		$req = $objAccesoDatos->PrepararConsulta("INSERT INTO usuarios (mail, clave, tipo) VALUES (:mail, :clave, :tipo)");

		$claveHash = password_hash($this->clave, PASSWORD_DEFAULT);
		$req->bindValue(':mail', $this->mail, PDO::PARAM_STR);
		$req->bindValue(':clave', $claveHash, PDO::PARAM_STR);
		$req->bindValue(':tipo', $this->tipo, PDO::PARAM_INT);
		$req->execute();

		return $objAccesoDatos->ObtenerUltimoId();
	}

	public static function TraerTodos()
	{
		$objAccesoDatos = AccesoDatos::ObtenerInstancia();
		$req = $objAccesoDatos->PrepararConsulta("SELECT * FROM usuarios");
		$req->execute();
		return $req->fetchAll(PDO::FETCH_CLASS, 'Usuario');
	}

	public static function TraerPorTipo($tipo)
	{
		$objAccesoDatos = AccesoDatos::ObtenerInstancia();
		$req = $objAccesoDatos->PrepararConsulta("SELECT * FROM usuarios WHERE tipo=:tipo");
		$req->bindValue(':tipo', $tipo, PDO::PARAM_STR);
		$req->execute();
		return $req->fetchAll(PDO::FETCH_CLASS, 'Usuario');
	}

	public static function TraerPorId($id)
	{
		$objAccesoDatos = AccesoDatos::ObtenerInstancia();
		$req = $objAccesoDatos->PrepararConsulta("SELECT * FROM usuarios WHERE id=:id");
		$req->bindValue(':id', $id, PDO::PARAM_INT);
		$req->execute();
		return $req->fetchAll(PDO::FETCH_CLASS, 'Usuario');
	}

	public static function TraerPorCripto($nombreCripto)
	{
		$objAccesoDatos = AccesoDatos::ObtenerInstancia();
		$req = $objAccesoDatos->PrepararConsulta(
			"SELECT usuarios.* FROM usuarios " .
			"JOIN ventas ON usuarios.id = ventas.idCliente " .
			"JOIN criptomonedas ON ventas.idCripto = criptomonedas.id " .
			"WHERE criptomonedas.nombre = :nombre"
		);
		$req->bindValue(':nombre', $nombreCripto, PDO::PARAM_STR);
		$req->execute();
		return $req->fetchAll(PDO::FETCH_CLASS, 'Usuario');
	}

}