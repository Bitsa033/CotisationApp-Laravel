<?php

namespace App\DataFixtures;

use App\Entity\Client;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // for ($i=1; $i <6 ; $i++) { 
        //     $client = new Client();
        //     $client->setNom('Client n°'.$i);
        //     $client->setContact('653-5'.$i.'-78-06');
        //     $manager->persist($client);
        //     $manager->flush();
        // }

    }
}
