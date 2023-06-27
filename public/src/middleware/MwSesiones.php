<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

include_once __DIR__ . "\..\models\AutentificadorJWT.php";

class MwAdmin
{
	public function __invoke(Request $request, RequestHandler $handler): Response
	{
		$response = new Response();
		
		if (isset($_COOKIE['token'])) {
			$token = $_COOKIE['token'];
			try {
				AutentificadorJWT::VerificarToken($token);
				$dataJWT = AutentificadorJWT::ObtenerData($token);
				if ($dataJWT->tipo == TIPO_ADMIN) {
					$response = $handler->handle($request);
					$response->withStatus(200);
				} else {
					$response->getBody()->write(json_encode(array("msg" => "Solo los administradores pueden realizar esta accion!")));
				}
			} catch (Exception $ex) {
				$response->getBody()->write($ex->getMessage());
			}
		} else {
			$response->getBody()->write(json_encode(array("msg" => "No hay un token registrado. Inicie sesion.")));
			$response=$response->withStatus(400);
		}

		return $response;
	}
}

class MwLogueado
{
	public function __invoke(Request $request, RequestHandler $handler): Response
	{
		$response = new Response();
		
		if (isset($_COOKIE['token'])) {
			try {
				AutentificadorJWT::VerificarToken($_COOKIE['token']);
				$response = $handler->handle($request);
			} catch (Exception $ex) {
				$response->getBody()->write($ex->getMessage());
			}
		} else {
			$response->getBody()->write(json_encode(array("msg" => "No hay un token registrado. Inicie sesion.")));
		}

		return $response;
	}
}