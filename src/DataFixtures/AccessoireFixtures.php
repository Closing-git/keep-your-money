<?php

namespace App\DataFixtures;

use App\Entity\Accessoire;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AccessoireFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $types = [
            "haut",
            "bas",
            "tete",
            "animal",
            "accessoireMainDroite",
            "accessoireMainGauche",
            "fond",
            "filtre"
        ];

        for ($i = 0; $i < 40; $i++) {
            $accessoire = new Accessoire();
            $accessoire->setNomAccessoire("Accessoire $i");
            $accessoire->setTypeAccessoire($types[random_int(0, 7)]);
            $accessoire->setPrixAccessoire(random_int(1, 150));
            $accessoire->setVisuelAccessoire("avatar_neutre.png");

            $manager->persist($accessoire);
        }
        $manager->flush();
    }
}
