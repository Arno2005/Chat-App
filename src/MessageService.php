<?php

namespace App;


use Doctrine\ORM\EntityManager;
use App\Domain\Message;

final class MessageService
{
    private EntityManager $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function sendText($user_id, $text, $file): Message
    {


        $message = new Message($user_id, $text, $file);

        $this->em->persist($message);
        $this->em->flush();

        return $message;
    }

    public function displayChat(){

        $chat = $this->em->createQueryBuilder()
        ->select('m.id', 'm.user_id', 'u.username', 'm.text', 'm.file')
        ->from('App\Domain\Message', 'm')
        ->leftJoin('App\Domain\User', 'u', 'WITH', 'm.user_id = u.id');

        $query = $chat->getQuery();

        $result = $query->getResult();
        
        return $result;
    }
}