<?php


namespace App\Controllers;


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\MessageService;

class MessageController
{
    private $messageService;

    public function __construct(MessageService $messageService)
    {
        $this->messageService = $messageService;
    }

    public function sendText(Request $request, Response $response)
    {

        $params = $request->getParsedBody();

        $file = $request->getUploadedFiles()['file'];

        if($file){
            $fileName = $file->getClientFilename();
        }

        
        if($fileName != '' && $file->getError() == 0){
            $fileName = str_replace(' ','_', $fileName);
            $filePath = __DIR__ ."/../../public/files/$fileName";
            $file->moveTo($filePath);
            
        }else{
            $fileName = '';
        }


        $user_id = $_SESSION['user']['id'];
        $text = $params['text'];


        $res = $this->messageService->sendText($user_id, $text, $fileName);
        $response->getBody()->write(json_encode(['user_id' => $user_id, 'text' => $text, 'file' => $fileName]));
        return $response->withStatus(200);
        
    }

    public function displayChat(Request $request, Response $response){

        $res = $this->messageService->displayChat();

        $res['my_id'] = $_SESSION['user']['id'];
        
        $response->getBody()->write(json_encode($res));
        return $response->withStatus(200);
    }
}