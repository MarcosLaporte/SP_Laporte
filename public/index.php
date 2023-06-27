<?php
// Error Handling
error_reporting(-1);
ini_set('display_errors', 1);

use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;

require __DIR__ . '\..\vendor\autoload.php';

include_once '.\src\controllers\UsuarioController.php';
include_once '.\src\controllers\CriptoController.php';
include_once '.\src\controllers\VentaController.php';
include_once '.\src\models\Log.php';

include_once '.\src\middleware\MwParams.php';
include_once '.\src\middleware\MwTipoUsuario.php';
include_once '.\src\middleware\MwSesiones.php';
include_once '.\src\middleware\MwCriptoNoExis.php';
include_once '.\src\middleware\MwIdCriptoExis.php';
include_once '.\src\middleware\MwIdUserExis.php';
include_once '.\src\middleware\MwCriptoLog.php';

$app = AppFactory::create();
$app->setBasePath('/public');
$app->addErrorMiddleware(true, true, true);
$app->addBodyParsingMiddleware();

$app->group('/usuarios', function (RouteCollectorProxy $group) {
	$group->post('/login', \UsuarioController::class . ':Login')
		->add(new MwTipoUsuario())
			->add(new MwUsuario());
	
	$group->get('/{cripto}', \UsuarioController::class . ':GetByCripto')
		->add(new MwAdmin());
});

$app->group('/cripto', function (RouteCollectorProxy $group) {
	$group->post('[/]', \CriptoController::class . ':Add')
		->add(new MwCriptoNoExis())
			->add(new MwCripto())
				->add(new MwAdmin());
	
				$group->get('[/]', \CriptoController::class . ':GetAll');
	
	$group->get('/nacionalidad/{nacion}', \CriptoController::class . ':GetByNation');
	
	$group->get('/id/{id}', \CriptoController::class . ':GetById')
		->add(new MwLogueado());
	
	$group->delete('[/]', \CriptoController::class . ':Delete')
		->add(new MwIdCriptoExis())
			->add(new MwAdmin())
				->add(new MwCriptoLog());
	
				$group->get('/csv', \CriptoController::class . ':DescargarCsv')
		->add(new MwLogueado());
	
	$group->put('[/]', \CriptoController::class . ':Modify')
		->add(new MwIdCriptoExis())
			->add(new MwAdmin());
});

$app->group('/ventas', function (RouteCollectorProxy $group) {
	$group->post('[/]', \VentaController::class . ':Add')
		->add(new MwVenta())
			->add(new MwIdUserExis())
				->add(new MwIdCriptoExis())
					->add(new MwLogueado());
	
					$group->get('/alemania', \VentaController::class . ':GetAlemanas')
		->add(new MwAdmin());
	
	$group->get('[/]', \VentaController::class . ':GetAll')
		->add(new MwLogueado());
});


$app->run();