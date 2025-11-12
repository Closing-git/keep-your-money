<?php

namespace App\DataFixtures;

use App\Entity\Accessoire;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AccessoireFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 40; $i++) {
            $accessoire = new Accessoire();
            $accessoire->setNomAccessoire("Accessoire $i");
            $accessoire->setTypeAccessoire("Type $i");
            $accessoire->setPrixAccessoire(random_int(1,150));
            $accessoire->setVisuelAccessoire("./assets/img/avatar_neutre.png");

            $manager->persist($accessoire);
        }
        $manager->flush();
    }
}
