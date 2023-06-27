<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

include_once __DIR__ . "\..\models\Log.php";
include_once __DIR__ . "\..\models\AutentificadorJWT.php";

class LogController extends Log
{
	public function Add(Request $request, Response $response, array $args)
	{
		$params = $request->getParsedBody();
		$token = $_COOKIE['token'];
		$dataToken = AutentificadorJWT::ObtenerData($token);
		
		$log = new Log();
		$log->idUsuario = $dataToken->id;
		$log->idCripto = $params['id'];
		$log->fecha_accion = date('Y-m-d');
		$log->accion = 'DELETE';
		$log->CrearLog();

		$payload = json_encode(array("msg" => "Log creado con exito"));
		$response->getBody()->write($payload);

		return $response->withHeader('Content-Type', 'application/json');
	}
}