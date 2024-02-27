<?php

namespace App;


use Doctrine\ORM\EntityManager;
use App\Domain\User;

final class UserService
{
    private EntityManager $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function createUser($username): User
    {


        $newUser = new User($username);

        $this->em->persist($newUser);
        $this->em->flush();

        return $newUser;
    }
}