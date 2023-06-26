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
				} else {
					$response->getBody()->write("Solo los administradores pueden realizar esta acción!");
				}
			} catch (Exception $ex) {
				$response->getBody()->write($ex->getMessage());
			}
		} else {
			$response->getBody()->write("No hay un token registrado. Inicie sesión.");
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
				$response->getBody()->write("Token inválido. Inicie sesión de nuevo.\n");
				$response->getBody()->write($ex->getMessage());
			}
		} else {
			$response->getBody()->write("No hay un token registrado. Inicie sesión.");
		}

		return $response;
	}
}