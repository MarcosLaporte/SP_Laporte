<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

class MwCriptoExistente
{
	public function __invoke(Request $request, RequestHandler $handler): Response
	{
		$response = new Response();
		$nombreCripto = $request->getParsedBody()['nombre'];

		if (empty(CriptoMoneda::TraerPorNombre($nombreCripto))) {
			$response = $handler->handle($request);
		} else {
			$response->getBody()->write("Ya existe una moneda con este nombre!");
		}

		return $response;
	}
}