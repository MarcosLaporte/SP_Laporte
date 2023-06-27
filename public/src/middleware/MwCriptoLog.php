<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

include_once __DIR__ . "\..\models\AutentificadorJWT.php";

class MwCriptoLog
{
	public function __invoke(Request $request, RequestHandler $handler): Response
	{
		$response = $handler->handle($request);

		if ($response->getStatusCode() == 200) {
			$params = $request->getParsedBody();
			$token = $_COOKIE['token'];
			$dataToken = AutentificadorJWT::ObtenerData($token);

			$log = new Log();
			$log->idUsuario = $dataToken->id;
			$log->idCripto = $params['idCripto'];
			$log->fecha_accion = date('Y-m-d');
			$log->accion = 'DELETE';
			$log->CrearLog();

			$response = new Response();
			$response->getBody()->write(json_encode(array("msg" => "Log agregado!")));
		}

		return $response;
	}
}