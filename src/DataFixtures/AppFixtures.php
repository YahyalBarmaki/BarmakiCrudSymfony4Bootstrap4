<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
Use Faker\Factory;

use App\Entity\Personne;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $faker = Factory::create('fr_FR');
        for ($i=0; $i < 50 ; $i++) { 
            $pers = new Personne();
            $pers->setNom($faker->firstName());
            $pers->setPrenom($faker->lastName());
            $manager->persist($pers);
        }
        $manager->flush();
    }
}
