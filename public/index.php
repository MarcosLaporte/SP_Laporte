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

include_once '.\src\middleware\MwParams.php';
include_once '.\src\middleware\MwTipoUsuario.php';

$app = AppFactory::create();
$app->setBasePath('/public');
$app->addErrorMiddleware(true, true, true);
$app->addBodyParsingMiddleware();

$app->group('/usuarios', function (RouteCollectorProxy $group) {
	$group->post('/login', \UsuarioController::class . ':Exists')->add(new MwTipoUsuario())->add(new MwUsuario());
});

$app->run();