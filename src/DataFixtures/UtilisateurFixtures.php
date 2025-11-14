<?php

namespace App\DataFixtures;

use App\Entity\Accessoire;
use App\Entity\Utilisateur;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class UtilisateurFixtures extends Fixture
{

    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; $i++) {
            $user = new Utilisateur();
            $user->setUsername("user" . $i);
            $user->setPassword($this->passwordHasher->hashPassword(
                $user,
                'mdp' . $i
            ));
            $user->setArgentPossede(random_int(0, 600));
            $fondBase = $manager->getRepository(Accessoire::class)->findOneBy([
                'nomAccessoire' => 'Nature'
            ]);
            $user->addPossession($fondBase);
            $manager->persist($user);
        }
        $manager->flush();
    }
}
