<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

include_once __DIR__ . "\..\models\CriptoMoneda.php";
include_once __DIR__ . "\..\models\Archivos.php";
include_once __DIR__ . "\..\models\AutentificadorJWT.php";

class CriptoController extends CriptoMoneda
{
	public static function Add(Request $request, Response $response, array $args)
	{
		$params = $request->getParsedBody();

		$cripto = new CriptoMoneda();
		$cripto->precio = $params['precio'];
		$cripto->nombre = $params['nombre'];
		$cripto->foto = Archivo::GuardarImagenDePeticion("public/src/FotosCripto/", $cripto->nombre, 'foto');
		$cripto->nacionalidad = $params['nacionalidad'];
		$cripto->CrearCripto();

		$payload = json_encode(array("msg" => "Cripto creada con exito"));
		$response->getBody()->write($payload);

		return $response->withHeader('Content-Type', 'application/json');
	}

	public static function GetAll(Request $request, Response $response, array $args)
	{
		$criptos = CriptoMoneda::TraerTodas();

		$payload = json_encode(array("list" => $criptos));
		$response->getBody()->write($payload);

		return $response->withHeader('Content-Type', 'application/json');
	}

	public static function GetByNation(Request $request, Response $response, array $args)
	{
		$criptos = CriptoMoneda::TraerPorNacionalidad($args['nacion']);

		$payload = json_encode(array("list" => $criptos));
		$response->getBody()->write($payload);

		return $response->withHeader('Content-Type', 'application/json');
	}

	public static function GetById(Request $request, Response $response, array $args)
	{
		$criptos = CriptoMoneda::TraerPorId($args['id']);

		$payload = json_encode(array("list" => $criptos));
		$response->getBody()->write($payload);

		return $response->withHeader('Content-Type', 'application/json');
	}
}