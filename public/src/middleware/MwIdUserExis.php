<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

include_once __DIR__ . "\..\models\Usuario.php";

class MwIdUserExis
{
	public function __invoke(Request $request, RequestHandler $handler): Response
	{
		$response = new Response();
		$idUser = $request->getParsedBody()['idCliente'];

		if (!empty(Usuario::TraerPorId($idUser))) {
			$response = $handler->handle($request);
		} else {
			$response->getBody()->write(json_encode(array("msg" => "No existe un usuario con ese ID.")));
		}

		return $response;
	}
}