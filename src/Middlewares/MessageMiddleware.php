<?php

namespace App\Middlewares;


use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Message\ResponseInterface as Response;

class MessageMiddleware
{
    /**
     *
     *
     * @param  Request        $request PSR-7 request
     * @param  RequestHandler $handler PSR-15 request handler
     *
     * @return Response
     */
    public function __invoke(Request $request, RequestHandler $handler): Response 
    {

        $params = $request->getParsedBody();

        $text = $params['text'];
    
        if($text != ''){

            $response = $handler->handle($request);

            return $response;
            
        }else{
            $err = [
                "msg" => "Invalid Format!",
            ];

            $res = new \Slim\Psr7\Response();
        
            $res->getBody()->write(json_encode($err));
            return $res->withStatus(403);
        }
    }
}