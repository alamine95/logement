<?php

namespace App\DataFixtures;

use App\Entity\Announce;
use App\Entity\Comment;
use DateTime;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\Factory;
use Cocur\Slugify\Slugify;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        
        $faker = Factory::create('fr_FR');
        $slugger = new Slugify();
        for ($i = 0; $i< 5; $i++) { 
        $announce = new Announce();
        $announce->setTitle($faker->sentence(3, false));
        //$announce->setSlug($slugger->slugify($announce->getTitle()));
        $announce->setDescription($faker->text(200));
        $announce->setPrice(mt_rand(30000, 100000));
        $announce->setAddress($faker->address());
        $announce->setCoverImage('https://picsum.photos/200/300');
        $announce->setRooms(mt_rand(0, 5));
        $announce->setIsAvailable(mt_rand(0, 1));
        $announce->setCreatedAt($faker->dateTimeBetween('-3 month', 'now'));

        for ($j = 0; $j< 5; $j++) { 
            $comment = new Comment();
            $comment->setAuthor($faker->name);
            //$announce->setSlug($slugger->slugify($announce->getTitle()));
            $comment->setEmail($faker->email());
            $comment->setContent($faker->text(200));
            $comment->setCreatedAt($faker->dateTimeBetween('-3 month', 'now'));
            $comment->setAnnounce($announce);

            
    
            $manager->persist($comment); // Permet à doctrine d'enregistrer l'annonce dans la BD
            $announce->addComment($comment);
        }

        $manager->persist($announce); // Permet à doctrine d'enregistrer l'annonce dans la BD
    }


   



        $manager->flush(); // Execute l'enregistrement des données persistées
    }
}
