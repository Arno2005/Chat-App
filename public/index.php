<?php


session_start();

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Exception\HttpNotFoundException;
use Slim\Factory\AppFactory;
use Slim\Views\PhpRenderer;
use App\Middlewares\MessageMiddleware;
use App\Controllers\MessageController;
use App\Controllers\UserController;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../bootstrap.php';

$app = AppFactory::createFromContainer($container);

$app->add(function (Request $request, RequestHandler $handler) {

    try {

      return $handler->handle($request);

    } catch (HttpNotFoundException $httpException) {

        $response = (new \Slim\Psr7\Response())->withStatus(404);
        $rend = new PhpRenderer(__DIR__ . '/templates');
        return $rend->render($response, '/404.php');

    }
});


$app->get('/', function (Request $request, Response $response){
    $rend = new PhpRenderer(__DIR__ . '/templates');
    return $rend->render($response, '/home.php');
});

$app->post("/user/check", [UserController::class, "checkUser"]);


$app->get('/chat/display', [MessageController::class,'displayChat']);

$app->post('/chat/send', [MessageController::class,'sendText'])->add(new MessageMiddleware);

$app->get('/file/get/{name}/{ext}', function (Request $request, Response $response, $args){

    $name = $args['name'];
    $ext = $args['ext'];
    $path = __DIR__ . '/files/' . $name . '.' . $ext;
    $file = file_get_contents($path);

    if($file === FALSE) {
       $handler = $this->notFoundHandler;
       return $handler($request, $response);    
    }

    $response = $response->withHeader('Cache-Control', 'public, max-age=3600'); // Cache for 1 hour
    $response = $response->withHeader('Expires', gmdate('D, d M Y H:i:s \G\M\T', time() + 3600));

    $response->getBody()->write($file);
    return $response->withHeader('Content-Type', mime_content_type($path));

});



$app->run();