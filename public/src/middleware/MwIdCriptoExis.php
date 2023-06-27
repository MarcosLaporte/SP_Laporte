<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

include_once __DIR__ . "\..\models\CriptoMoneda.php";

class MwIdCriptoExis
{
	public function __invoke(Request $request, RequestHandler $handler): Response
	{
		$response = new Response();
		$idCripto = $request->getParsedBody()['idCripto'];

		if (!empty(CriptoMoneda::TraerPorId($idCripto))) {
			$response = $handler->handle($request);
		} else {
			$response->getBody()->write(json_encode(array("msg" => "No existe una moneda con ese id!")));
			$response=$response->withStatus(400);
		}

		return $response;
	}
}