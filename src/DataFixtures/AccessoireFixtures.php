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
            "chaussure",
            "fond",
            "filtre"
        ];


        //ACCESSOIRES MAIN DROITE
        $ballon = new Accessoire();
        $ballon->setNomAccessoire("Ballon");
        $ballon->setTypeAccessoire("accessoireMainDroite");
        $ballon->setPrixAccessoire(random_int(1, 150));
        $ballon->setVisuelAccessoire("Ballon-main-d.png");

        $manager->persist($ballon);

        $bouquet = new Accessoire();
        $bouquet->setNomAccessoire("Bouquet");
        $bouquet->setTypeAccessoire("accessoireMainDroite");
        $bouquet->setPrixAccessoire(random_int(1, 150));
        $bouquet->setVisuelAccessoire("Bouquet-main-d.png");

        $manager->persist($bouquet);

        $epee = new Accessoire();
        $epee->setNomAccessoire("Epée");
        $epee->setTypeAccessoire("accessoireMainDroite");
        $epee->setPrixAccessoire(random_int(1, 150));
        $epee->setVisuelAccessoire("Epee-main-d.png");

        $manager->persist($epee);


        //ACCESSOIRES MAIN GAUCHE

        $excalibur = new Accessoire();
        $excalibur->setNomAccessoire("Excalibur");
        $excalibur->setTypeAccessoire("accessoireMainGauche");
        $excalibur->setPrixAccessoire(random_int(1, 150));
        $excalibur->setVisuelAccessoire("Excalibur-main-g.png");

        $manager->persist($excalibur);

        $hache = new Accessoire();
        $hache->setNomAccessoire("Hache");
        $hache->setTypeAccessoire("accessoireMainGauche");
        $hache->setPrixAccessoire(random_int(1, 150));
        $hache->setVisuelAccessoire("Hache-main-g.png");

        $manager->persist($hache);

        $pelle = new Accessoire();
        $pelle->setNomAccessoire("Pelle");
        $pelle->setTypeAccessoire("accessoireMainGauche");
        $pelle->setPrixAccessoire(random_int(1, 150));
        $pelle->setVisuelAccessoire("Pelle-main-g.png");

        $manager->persist($pelle);

        //ACCESSOIRES TETE

        $diplome = new Accessoire();
        $diplome->setNomAccessoire("Chapeau de diplômé");
        $diplome->setTypeAccessoire("tete");
        $diplome->setPrixAccessoire(random_int(1, 150));
        $diplome->setVisuelAccessoire("Chapeau-diplome.png");

        $manager->persist($diplome);

        $paille = new Accessoire();
        $paille->setNomAccessoire("Chapeau de paille");
        $paille->setTypeAccessoire("tete");
        $paille->setPrixAccessoire(random_int(1, 150));
        $paille->setVisuelAccessoire("Chapeau-paille.png");

        $manager->persist($paille);

        $sorciere = new Accessoire();
        $sorciere->setNomAccessoire("Chapeau de sorcière");
        $sorciere->setTypeAccessoire("tete");
        $sorciere->setPrixAccessoire(random_int(1, 150));
        $sorciere->setVisuelAccessoire("Chapeau-sorciere.png");

        $manager->persist($sorciere);

        //ANIMAUX

        $chat = new Accessoire();
        $chat->setNomAccessoire("Chat");
        $chat->setTypeAccessoire("animal");
        $chat->setPrixAccessoire(random_int(1, 150));
        $chat->setVisuelAccessoire("Chat.png");

        $manager->persist($chat);

        $dragon = new Accessoire();
        $dragon->setNomAccessoire("Dragon");
        $dragon->setTypeAccessoire("animal");
        $dragon->setPrixAccessoire(random_int(1, 150));
        $dragon->setVisuelAccessoire("Dragon.png");

        $manager->persist($dragon);

        $grenouille = new Accessoire();
        $grenouille->setNomAccessoire("Grenouille");
        $grenouille->setTypeAccessoire("animal");
        $grenouille->setPrixAccessoire(random_int(1, 150));
        $grenouille->setVisuelAccessoire("Grenouille.png");

        $manager->persist($grenouille);

        //Chaussures

        $chaussureRouge = new Accessoire();
        $chaussureRouge->setNomAccessoire("Chaussures rouges");
        $chaussureRouge->setTypeAccessoire("chaussure");
        $chaussureRouge->setPrixAccessoire(random_int(1, 150));
        $chaussureRouge->setVisuelAccessoire("Chaussures-rouge.png");

        $manager->persist($chaussureRouge);


        $chaussureBrune = new Accessoire();
        $chaussureBrune->setNomAccessoire("Chaussures brunes");
        $chaussureBrune->setTypeAccessoire("chaussure");
        $chaussureBrune->setPrixAccessoire(random_int(1, 150));
        $chaussureBrune->setVisuelAccessoire("Chaussures-brune.png");

        $manager->persist($chaussureBrune);

        $chaussureGrise = new Accessoire();
        $chaussureGrise->setNomAccessoire("Chaussures grises");
        $chaussureGrise->setTypeAccessoire("chaussure");
        $chaussureGrise->setPrixAccessoire(random_int(1, 150));
        $chaussureGrise->setVisuelAccessoire("Chaussures-grise.png");

        $manager->persist($chaussureGrise);

        //Filtres

        $filtreAmour = new Accessoire();
        $filtreAmour->setNomAccessoire("Love is in the air");
        $filtreAmour->setTypeAccessoire("filtre");
        $filtreAmour->setPrixAccessoire(random_int(1, 150));
        $filtreAmour->setVisuelAccessoire("Filtre-amour.png");

        $manager->persist($filtreAmour);


        $filtreAutomne = new Accessoire();
        $filtreAutomne->setNomAccessoire("Automne");
        $filtreAutomne->setTypeAccessoire("filtre");
        $filtreAutomne->setPrixAccessoire(random_int(1, 150));
        $filtreAutomne->setVisuelAccessoire("Filtre-automne.png");

        $manager->persist($filtreAutomne);
        
        $filtrePaillettes = new Accessoire();
        $filtrePaillettes->setNomAccessoire("Des paillettes Kévin");
        $filtrePaillettes->setTypeAccessoire("filtre");
        $filtrePaillettes->setPrixAccessoire(random_int(1, 150));
        $filtrePaillettes->setVisuelAccessoire("Filtre-paillettes.png");

        $manager->persist($filtrePaillettes);

        //Fond

        $fondBase = new Accessoire();
        $fondBase->setNomAccessoire("Nature");
        $fondBase->setTypeAccessoire("fond");
        $fondBase->setPrixAccessoire(random_int(1, 150));
        $fondBase->setVisuelAccessoire("fond-base.png");

        $manager->persist($fondBase);

        $fondPlage = new Accessoire();
        $fondPlage->setNomAccessoire("Plage");
        $fondPlage->setTypeAccessoire("fond");
        $fondPlage->setPrixAccessoire(0);
        $fondPlage->setVisuelAccessoire("fond-plage.png");

        $manager->persist($fondPlage);

        $fondVille = new Accessoire();
        $fondVille->setNomAccessoire("Ville");
        $fondVille->setTypeAccessoire("fond");
        $fondVille->setPrixAccessoire(random_int(1, 150));
        $fondVille->setVisuelAccessoire("fond-ville.png");

        $manager->persist($fondVille);

        //Bas

        $pantBleu = new Accessoire();
        $pantBleu->setNomAccessoire("Pantalon bleu");
        $pantBleu->setTypeAccessoire("bas");
        $pantBleu->setPrixAccessoire(random_int(1, 150));
        $pantBleu->setVisuelAccessoire("Pantalon-bleu.png");

        $manager->persist($pantBleu);

        $pantBrun = new Accessoire();
        $pantBrun->setNomAccessoire("Pantalon brun");
        $pantBrun->setTypeAccessoire("bas");
        $pantBrun->setPrixAccessoire(random_int(1, 150));
        $pantBrun->setVisuelAccessoire("Pantalon-brun.png");

        $manager->persist($pantBrun);

        $pantOrange = new Accessoire();
        $pantOrange->setNomAccessoire("Short orange");
        $pantOrange->setTypeAccessoire("bas");
        $pantOrange->setPrixAccessoire(random_int(1, 150));
        $pantOrange->setVisuelAccessoire("Pantalon-orange.png");

        $manager->persist($pantOrange);

        //Haut

        $pullRaye = new Accessoire();
        $pullRaye->setNomAccessoire("Pull rayé");
        $pullRaye->setTypeAccessoire("haut");
        $pullRaye->setPrixAccessoire(random_int(1, 150));
        $pullRaye->setVisuelAccessoire("Pull-raye.png");

        $manager->persist($pullRaye);

        $pullRose = new Accessoire();
        $pullRose->setNomAccessoire("Pull rose");
        $pullRose->setTypeAccessoire("haut");
        $pullRose->setPrixAccessoire(random_int(1, 150));
        $pullRose->setVisuelAccessoire("Pull-rose.png");

        $manager->persist($pullRose);

        $pullVert = new Accessoire();
        $pullVert->setNomAccessoire("Pull vert");
        $pullVert->setTypeAccessoire("haut");
        $pullVert->setPrixAccessoire(random_int(1, 150));
        $pullVert->setVisuelAccessoire("Pull-vert.png");

        $manager->persist($pullVert);
        
        $manager->flush();
    }
}
