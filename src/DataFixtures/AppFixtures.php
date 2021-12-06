<?php

namespace App\DataFixtures;

use App\Entity\Task;
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
        $manager->persist($admin);

        $todo = new ToDo();
        $todo->setCreator($admin)
            ->setName('liste une');
        $manager->persist($todo);

        $task = new Task();
        $task->setName('Tache 1')
            ->setToDo($todo)
            ->setStatus(Task::STATE_CREATED);
        $manager->persist($task);

        $user = new User();
        $user->setUsername('Nicolas');
        $password = $this->hasher->hashPassword($user,'password');
        $user->setPassword($password);
        $manager->persist($user);




        $manager->flush();
    }
}
