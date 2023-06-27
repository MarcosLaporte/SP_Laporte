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
				$response->getBody()->write(json_encode(array("msg" => "Revise los datos ingresados!")));
			}
		} else {
			$response->getBody()->write(json_encode(array("msg" => "Ingrese los datos del usuario!")));
		}

		return $response;
	}
}

class MwCripto
{
	public function __invoke(Request $request, RequestHandler $handler): Response
	{
		$response = new Response();
		$params = $request->getParsedBody();
		$paramFiles = $request->getUploadedFiles();

		if (isset($params['precio']) && isset($params['nombre']) && isset($paramFiles['foto']) && isset($params['nacionalidad'])) {
			if (
				!empty(doubleval($params['precio']))
				&& !empty($params['nombre'])
				&& $paramFiles['foto']->getError() == UPLOAD_ERR_OK
				&& !empty($params['nacionalidad'])
			) {
				$response = $handler->handle($request);
			} else {
				$response->getBody()->write(json_encode(array("msg" => "Revise los datos ingresados!")));
			}
		} else {
			$response->getBody()->write(json_encode(array("msg" => "Ingrese los datos de la cripto!")));
		}

		return $response;
	}
}

class MwVenta
{
	public function __invoke(Request $request, RequestHandler $handler): Response
	{
		$response = new Response();
		$params = $request->getParsedBody();
		$paramFiles = $request->getUploadedFiles();

		if (isset($params['fecha']) && isset($params['cantidad']) && isset($params['idCripto']) && isset($params['idCliente']) && isset($paramFiles['foto'])) {
			if (
				!empty($params['fecha'])
				&& !empty(floatval($params['cantidad']))
				&& !empty(intval($params['idCripto']))
				&& !empty($params['idCliente'])
				&& $paramFiles['foto']->getError() == UPLOAD_ERR_OK
			) {
				if (DateTime::createFromFormat('Y-m-d', $params['fecha'])) {
					$response = $handler->handle($request);
				} else {
					$response->getBody()->write(json_encode(array("msg" => "La fecha debe ser AAAA-MM-DD.")));
				}
			} else {
				$response->getBody()->write(json_encode(array("msg" => "Revise los datos ingresados!")));
			}
		} else {
			$response->getBody()->write(json_encode(array("msg" => "Ingrese los datos de la venta!")));
		}

		return $response;
	}
}