<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

class MwUsuario
{
	public function __invoke(Request $request, RequestHandler $handler): Response
	{
		$response = new Response();
		$params = $request->getParsedBody();

		if (isset($params['mail']) && isset($params['clave']) && isset($params['tipo'])) {
			if (
				!empty($params['mail'])
				&& !empty($params['clave'])
				&& !is_null(intval($params['tipo']))
			) {
				$response = $handler->handle($request);
			} else {
				$response->getBody()->write("Revise los datos ingresados!");
			}
		} else {
			$response->getBody()->write("Ingrese los datos del usuario!");
		}

		return $response;
	}
}