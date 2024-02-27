<?php

namespace App\Domain;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

#[Entity, Table(name: 'messages')]


final class Message
{
    #[Id, Column(type: 'integer'), GeneratedValue(strategy: 'AUTO')]
    private int $id;

    #[Column(type: 'integer')]
    private int $user_id;


    #[Column(type: 'string', nullable: false)]
    private string $text;


    #[Column(type: 'string', nullable: true)]
    private string $file;


    public function __construct(int $user_id, string $text, string $file)
    {
        $this->user_id = $user_id;
        $this->text = $text;
        $this->file = $file;
    }

    public function getId(): int
    {
        return $this->id;
    }

}