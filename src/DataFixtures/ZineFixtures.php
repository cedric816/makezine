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

        //create 3 fanzine for user 'user@mail.com'
        for ($f=1; $f<=3; $f++){
            $fanzine = new Fanzine();
            $fanzine->setUser($user);
            $fanzine->setCreatedAt(new DateTimeImmutable());
            $fanzine->setTitle('fanzine n°'.$f);

            $manager->persist($fanzine);

            //for each fanzine, create 8 pages
            for ($p=1; $p<=8; $p++){
                $page = new Page();
                $page->setFanzine($fanzine);
                $page->setPosition($p);

                $manager->persist($page);

                //for each page, create 2 modules: 1 title and 1 paragraph
                $title = new Module();
                $title->setPage($page);
                $title->setContent('Titre');
                $title->setPosition(1);
                $title->setType('title');
                $title->setSpeeled(1);
                $title->setColor('#000000');

                $manager->persist($title);

                $paragraph = new Module();
                $paragraph->setPage($page);
                $paragraph->setContent('lorem ipsum lorem ipsum lorem ipsum!');
                $paragraph->setPosition(2);
                $paragraph->setType('paragraph');
                $paragraph->setSpeeled(0);
                $paragraph->setColor('#000000');

                $manager->persist($paragraph);
            }
            
        }
      
        $manager->flush();
    }
}
