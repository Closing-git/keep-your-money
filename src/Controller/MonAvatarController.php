<?php

namespace App\Controller;

use App\Entity\Accessoire;
use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

final class MonAvatarController extends AbstractController
{
    #[Route('/monavatar', name: 'app_mon_avatar')]
    public function index(EntityManagerInterface $em): Response
    {
        //Récupérer l'utilisateur connecté et son argent
        $utilisateurConnecte = $this->getUser();
        $utilisateur = $em->getRepository(Utilisateur::class)->find($utilisateurConnecte->getId());
        $argentPossede = $utilisateur->getArgentPossede();
        if (!$utilisateur) {
            return $this->redirectToRoute('app_login');
        }
        
         $accessoiresPossedes = $utilisateur->getPossession();
         $argentPossede = $utilisateur->getArgentPossede();
         $tenuePortee = $utilisateur->getTenuePortee();


     
    $accessoires = $em->getRepository(Accessoire::class)->findAll();

        $fonds = array_filter($accessoires, fn($a) => $a->getTypeAccessoire() === 'fond');

       // Filtrer uniquement ceux que l'utilisateur possède
       $idsPossedes = array_map(fn($a) => $a->getId(), $accessoiresPossedes->toArray());
$fondsPossedes = array_filter($fonds, function($fond) use ($idsPossedes) {
    foreach ($idsPossedes as $idPossede) {
        if ($fond->getId() === $idPossede) {
            return true;
        }
    }
    return false;
});

 $haut= array_filter($accessoires, fn($a) => $a->getTypeAccessoire() === 'haut');

       
$hautPossedes = array_filter($haut, function($haut) use ($idsPossedes) {
    foreach ($idsPossedes as $idPossede) {
        if ($haut->getId() === $idPossede) {
            return true;
        }
    }
    return false;
});
 $bas= array_filter($accessoires, fn($a) => $a->getTypeAccessoire() === 'bas');

       
$basPossedes = array_filter($bas, function($bas) use ($idsPossedes) {
    foreach ($idsPossedes as $idPossede) {
        if ($bas->getId() === $idPossede) {
            return true;
        }
    }
    return false;
});
 $chaussures= array_filter($accessoires, fn($a) => $a->getTypeAccessoire() === 'chaussure');

       
$chaussuresPossedes = array_filter($chaussures, function($chaussure) use ($idsPossedes) {
    foreach ($idsPossedes as $idPossede) {
        if ($chaussure->getId() === $idPossede) {
            return true;
        }
    }
    return false;
});
 $tete= array_filter($accessoires, fn($a) => $a->getTypeAccessoire() === 'tete');

       
$tetePossedes = array_filter($tete, function($tete) use ($idsPossedes) {
    foreach ($idsPossedes as $idPossede) {
        if ($tete->getId() === $idPossede) {
            return true;
        }
    }
    return false;
});
 $accessoireMainDroite= array_filter($accessoires, fn($a) => $a->getTypeAccessoire() === 'accessoireMainDroite');

       
$accessoireMainDroitePossedes = array_filter($accessoireMainDroite, function($accessoireMainDroite) use ($idsPossedes) {
    foreach ($idsPossedes as $idPossede) {
        if ($accessoireMainDroite->getId() === $idPossede) {
            return true;
        }
    }
    return false;
});
 $accessoireMainGauche= array_filter($accessoires, fn($a) => $a->getTypeAccessoire() === 'accessoireMainGauche');

       
$accessoireMainGauchePossedes = array_filter($accessoireMainGauche, function($accessoireMainGauche) use ($idsPossedes) {
    foreach ($idsPossedes as $idPossede) {
        if ($accessoireMainGauche->getId() === $idPossede) {
            return true;
        }
    }
    return false;
});
 $animal= array_filter($accessoires, fn($a) => $a->getTypeAccessoire() === 'animal');

       
$animalPossedes = array_filter($animal, function($animal) use ($idsPossedes) {
    foreach ($idsPossedes as $idPossede) {
        if ($animal->getId() === $idPossede) {
            return true;
        }
    }
    return false;
});
 $filtre= array_filter($accessoires, fn($a) => $a->getTypeAccessoire() === 'filtre');

       
$filtrePossedes = array_filter($filtre, function($filtre) use ($idsPossedes) {
    foreach ($idsPossedes as $idPossede) {
        if ($filtre->getId() === $idPossede) {
            return true;
        }
    }
    return false;
});
    
        //Récupérer la tenue de l'utilisateur
        $tenuePortee = $utilisateur->getTenuePortee();

        $vars = [
            'utilisateur' => $utilisateur,
            'argentPossede' => $argentPossede,
            'accessoiresPossedes' => $accessoiresPossedes,
            'tenuePortee' => $tenuePortee,
             'fondsPossedes' => $fondsPossedes,
        ];
        return $this->render('mon_avatar/mon_avatar.html.twig', $vars);
    }
#[Route('/monavatar/sauvegarder', name: 'app_mon_avatar_sauvegarder', methods: ['POST'])]
public function sauvegarder(EntityManagerInterface $em, Request $request): JsonResponse
{
    $data = json_decode($request->getContent(), true);
    $fond = $data['fond'] ?? null;
    $user = $this->getUser();


    $fond = $em->getRepository(Accessoire::class)->findOneBy([
        'visuelAccessoire' => $fondNom
    ]);

    $user->setfondPossede($fond);

    $em->persist($user);
    $em->flush();

    return $this->json(['message' => 'Fond sauvegardé !']);
}
  


}


