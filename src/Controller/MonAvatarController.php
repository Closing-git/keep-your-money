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


