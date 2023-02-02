<?php

namespace App\DataFixtures;

use App\Entity\Client;
use App\Entity\Compte as EntityCompte;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class Compte extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $cl=new Client;
        $cl->setNom('Raoul');
        $cl->setContact('690 70 25 00');
        $c = new EntityCompte();
        $c->setNumero(rand(100,9000));
        $c->setSolde(0);
        $c->setDateT(new \dateTime());
        $c->setClient($cl);
         $manager->persist($c);

        $manager->flush();
    }
}
