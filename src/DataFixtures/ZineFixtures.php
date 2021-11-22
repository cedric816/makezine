<?php

namespace App\DataFixtures;

use App\Entity\User;
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
        //create two user
        $user = new User();
        $user->setEmail('user@mail.com');
        $user->setPassword($this->passwordHasher->hashPassword($user, 'pass'));
        $user->setRoles(['ROLE_USER']);
        $user->setPseudo('user');
        $manager->persist($user);

        $user2 = new User();
        $user2->setEmail('ced@mail.com');
        $user2->setPassword($this->passwordHasher->hashPassword($user, 'pass'));
        $user2->setRoles(['ROLE_USER']);
        $user2->setPseudo('ced');
        $manager->persist($user2);

        $manager->flush();      
    }
}
