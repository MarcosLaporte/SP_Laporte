<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

include_once __DIR__ . "\..\models\CriptoMoneda.php";
include_once __DIR__ . "\..\models\Archivos.php";
include_once __DIR__ . "\..\models\AutentificadorJWT.php";

class CriptoController extends CriptoMoneda
{
	public static function Add(Request $request, Response $response, array $args)
	{
		$params = $request->getParsedBody();

		$cripto = new CriptoMoneda();
		$cripto->precio = $params['precio'];
		$cripto->nombre = $params['nombre'];
		$cripto->foto = Archivo::GuardarImagenDePeticion("src/FotosCripto/", $cripto->nombre, 'foto');
		$cripto->nacionalidad = $params['nacionalidad'];
		$cripto->CrearCripto();

		$payload = json_encode(array("msg" => "Cripto creada con exito"));
		$response->getBody()->write($payload);

		return $response->withHeader('Content-Type', 'application/json');
	}

	public static function GetAll(Request $request, Response $response, array $args)
	{
		$criptos = CriptoMoneda::TraerTodas();

		$payload = json_encode(array("list" => $criptos));
		$response->getBody()->write($payload);

		return $response->withHeader('Content-Type', 'application/json');
	}

	public static function GetByNation(Request $request, Response $response, array $args)
	{
		$criptos = CriptoMoneda::TraerPorNacionalidad($args['nacion']);

		$payload = json_encode(array("list" => $criptos));
		$response->getBody()->write($payload);

		return $response->withHeader('Content-Type', 'application/json');
	}

	public static function GetById(Request $request, Response $response, array $args)
	{
		$criptos = CriptoMoneda::TraerPorId($args['id']);

		$payload = json_encode(array("list" => $criptos));
		$response->getBody()->write($payload);

		return $response->withHeader('Content-Type', 'application/json');
	}

	public static function Delete(Request $request, Response $response, array $args)
	{
		$params = $request->getParsedBody();
		$id = $params['idCripto'];
		$cripto = CriptoMoneda::TraerPorId($id);
		CriptoMoneda::BorrarUna($id);
		
		Archivo::MoverImagen("src/FotosCripto/", "src/CriptoBackUp/", $cripto[0]->nombre . '.jpg');

		$payload = json_encode(array("msg" => "Criptomoneda eliminada!"));
		$response->getBody()->write($payload);

		return $response->withHeader('Content-Type', 'application/json');
	}

	public static function Modify(Request $request, Response $response, array $args)
	{
		$params = $request->getParsedBody();
		$id = $params['idCripto'];
		$cripto = CriptoMoneda::TraerPorId($id);

		if (!empty($cripto)) {
			$precio = empty($params['precio']) ? $cripto[0]->precio : $params['precio'];
			$nombre = empty($params['nombre']) ? $cripto[0]->nombre : $params['nombre'];
			$nacionalidad = empty($params['nacionalidad']) ? $cripto[0]->nacionalidad : $params['nacionalidad'];
			$cripto[0]->Modificar($precio, $nombre, $nacionalidad);
			$payload = json_encode(array("msg" => "Criptomoneda modificada!"));
		} else {
			$payload = json_encode(array("msg" => "No existe esa cripto!"));
		}
		
		$response->getBody()->write($payload);
		return $response->withHeader('Content-Type', 'application/json');
	}

	public static function DescargarCsv(Request $request, Response $response, array $args)
	{
		if (CriptoMoneda::DbToCsv("src\db\database.csv"))
			$payload = json_encode(array("msg" => "Las criptomonedas se bajaron correctamente!"));
		else
			$payload = json_encode(array("msg" => "Hubo un problema al bajar las criptomonedas."));

		$response->getBody()->write($payload);
		return $response->withHeader('Content-Type', 'application/json');
	}
}