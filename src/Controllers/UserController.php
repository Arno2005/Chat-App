<?php


namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\UserService;
use App\MessageService;

//require __DIR__ . '../../vendor/autoload.php';

class UserController
{
    private $userService;

    private $messageService;

    public function __construct(UserService $userService, MessageService $messageService)
    {
        $this->userService = $userService;
        $this->messageService = $messageService;
    }

    public function checkUser(Request $request, Response $response, $args)
    {

        if(!isset($_SESSION['user'])){

            $faker = \Faker\Factory::create();
        
            $username = $faker->name;
            $user = $this->userService->createUser($username);
            $message = $this->messageService->sendText(0, "$username has joined the chat", '');
        
            $user_id = $user->getId();

            $_SESSION['user']['id'] = $user_id;
    
        }else{
            $user_id = $_SESSION['user']['id'];
        }
    
        $res = [
            "user_id" => $user_id,
        ];
    
        $response->getBody()->write(json_encode($res));
        return $response->withStatus(200);
    }
}