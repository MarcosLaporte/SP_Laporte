<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

include_once __DIR__ . "\..\models\Usuario.php";
include_once __DIR__ . "\..\models\AutentificadorJWT.php";

class UsuarioController extends Usuario
{
	public static function Login(Request $request, Response $response, array $args)
	{
		$params = $request->getParsedBody();
		$usuario = Usuario::TraerPorId($params['id']);
		if (!empty($usuario)) {
			if (
				!strcasecmp($params['mail'], $usuario[0]->mail)
				&& password_verify($params['clave'], $usuario[0]->clave)
				&& $params['tipo'] == $usuario[0]->tipo
			) {
				$tipoStr = $usuario[0]->tipo == 0 ? "ADMIN"  : "CLIENTE";
				$payload = json_encode(array('msg' => "OK", 'tipo' => $tipoStr));
				
				$jwt = AutentificadorJWT::CrearToken(array('id' => $usuario[0]->id, 'tipo' => $usuario[0]->tipo));
				setcookie("token", $jwt, time()+1800, '/', "localhost", false, true);
			} else {
				setcookie("token", " ", time()-3600, '/', "localhost", false, true);
				$payload = json_encode(array('msg' => "Los datos del usuario #{$params['id']} no coinciden."));
			}
		} else {
			$payload = json_encode(array('msg' => "No existe un usuario con ese id."));
		}

		$response->getBody()->write($payload);
		return $response->withHeader('Content-Type', 'application/json');
	}

	public static function GetByCripto(Request $request, Response $response, array $args)
	{
		$cripto = $args['cripto'];

		$usuarios = Usuario::TraerPorCripto($cripto);
		$response->getBody()->write(json_encode(array("list" => $usuarios)));

		return $response->withHeader('Content-Type', 'application/json');
	}
}