<?php
#$paramFiles['foto']->getError() == UPLOAD_ERR_OK
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
		Archivo::GuardarImagenDePeticion(__DIR__ . "/../../src/FotosCripto/", $cripto->nombre, 'foto');
		$cripto->foto = "public/src/FotosMesas/$cripto->nombre.jpg";
		$cripto->nacionalidad = $params['nacionalidad'];
		$cripto->CrearCripto();

		$payload = json_encode(array("msg" => "Cripto creada con exito"));
		$response->getBody()->write($payload);

		return $response->withHeader('Content-Type', 'application/json');
	}
}