<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class Fixtures extends Fixture
{
    public function __construct(UserPasswordHasherInterface $encoder){
        $this->encoder=$encoder;
    }
    public function load(ObjectManager $manager): void
    {
        $fake = Factory::create();
        for($i=0;$i<10;$i++){
         //$manager = $this->doctrine->getManager();
         $user = new User();
         $hash = $this->encoder->hashPassword($user,'password');
         $user->setEmail($fake->email)
            ->setPassword($hash);
        $manager -> persist($user);

        for($j=0;$j<5;$j++){
            $article = new Article();
            $article->setName($fake->text(50))
                    ->setContent($fake->text(300))
                    ->setAuthor($user);
        $manager -> persist($article);
        }
    }

        $manager->flush();
    }
}
