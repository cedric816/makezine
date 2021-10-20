<?php

namespace App\DataFixtures;

use App\Entity\Fanzine;
use App\Entity\Module;
use App\Entity\Page;
use App\Entity\User;
use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ZineFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        //create a user
        $user = new User();
        $user->setEmail('user@mail.com');
        $user->setPassword($this->passwordHasher->hashPassword($user, 'pass'));
        $user->setRoles(['ROLE_USER']);
        $manager->persist($user);

        $manager->flush();      
    }
}
