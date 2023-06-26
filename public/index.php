<?php
// Error Handling
error_reporting(-1);
ini_set('display_errors', 1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;
use Slim\Routing\RouteContext;

require __DIR__ . '\..\vendor\autoload.php';

include_once '.\src\controllers\UsuarioController.php';
include_once '.\src\controllers\CriptoController.php';
include_once '.\src\controllers\VentaController.php';

include_once '.\src\middleware\MwParams.php';
include_once '.\src\middleware\MwTipoUsuario.php';
include_once '.\src\middleware\MwLogs.php';
include_once '.\src\middleware\MwCriptoNoExis.php';
include_once '.\src\middleware\MwIdCriptoExis.php';
include_once '.\src\middleware\MwIdUserExis.php';

$app = AppFactory::create();
$app->setBasePath('/public');
$app->addErrorMiddleware(true, true, true);
$app->addBodyParsingMiddleware();

$app->group('/usuarios', function (RouteCollectorProxy $group) {
	$group->post('/login', \UsuarioController::class . ':Login')->add(new MwTipoUsuario())->add(new MwUsuario());
});

$app->group('/cripto', function (RouteCollectorProxy $group) {
	$group->post('/alta', \CriptoController::class . ':Add')->add(new MwCriptoNoExis())->add(new MwCripto())->add(new MwAdmin());
	$group->get('[/]', \CriptoController::class . ':GetAll');
	$group->get('/nacionalidad/{nacion}', \CriptoController::class . ':GetByNation');
	$group->get('/id/{id}', \CriptoController::class . ':GetById')->add(new MwLogueado());
});

$app->group('/ventas', function (RouteCollectorProxy $group) {
	$group->post('[/]', \VentaController::class . ':Add')->add(new MwVenta())->add(new MwIdUserExis())->add(new MwIdCriptoExis())->add(new MwLogueado());
	$group->get('[/]', \VentaController::class . ':GetAlemanas')->add(new MwAdmin());
});


$app->run();