<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

class MwTipoUsuario
{
	public function __invoke(Request $request, RequestHandler $handler): Response
	{
		$response = new Response();
		$params = $request->getParsedBody();

		if (isset($params['tipo'])) {
			if ($params['tipo'] == 0 || $params['tipo'] == 1) {
				$response = $handler->handle($request);
			} else {
				$response->getBody()->write(json_encode(array("msg" => "Revise el tipo ingresado!")));
			}
		} else {
			$response->getBody()->write(json_encode(array("msg" => "Ingrese el tipo del usuario!")));
		}

		return $response;
	}
}