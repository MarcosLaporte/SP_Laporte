<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

include_once __DIR__ . "\..\models\VentaCripto.php";
include_once __DIR__ . "\..\models\CriptoMoneda.php";
include_once __DIR__ . "\..\models\Archivos.php";
include_once __DIR__ . "\..\models\AutentificadorJWT.php";

class VentaController extends VentaCripto
{
	public static function Add(Request $request, Response $response, array $args)
	{
		$params = $request->getParsedBody();

		$venta = new VentaCripto();
		$venta->fecha = $params['fecha'];
		$venta->cant = doubleval($params['cantidad']);
		$venta->idCripto = intval($params['idCripto']);
		$venta->idCliente = intval($params['idCliente']);
		
		$clienteMail = Usuario::TraerPorId($venta->idCliente)[0]->mail;
		$usuario = explode('@', $clienteMail)[0];
		$cripto = CriptoMoneda::TraerPorId($venta->idCripto);
		$nombreFoto = "{$cripto[0]->nombre}_{$usuario}_{$venta->fecha}";
		$venta->foto = Archivo::GuardarImagenDePeticion("src/FotosCripto2023/", $nombreFoto, 'foto');
		
		$venta->NuevaVenta();

		$payload = json_encode(array("msg" => "Venta agregada con exito."));
		$response->getBody()->write($payload);

		return $response->withHeader('Content-Type', 'application/json');
	}
}