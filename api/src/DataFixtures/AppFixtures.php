<?php

namespace App\DataFixtures;

use App\Entity\ToDo;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }


    public function load(ObjectManager $manager): void
    {
        $admin = new User();
        $admin->setUsername('admin');
        $password = $this->hasher->hashPassword($admin,'password');
        $admin->setPassword($password);

        $todo = new ToDo();


        $manager->persist($admin);



        $manager->flush();
    }
}
