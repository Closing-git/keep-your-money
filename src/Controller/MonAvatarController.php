<?php

namespace App\Controller;

use App\Entity\Accessoire;
use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class MonAvatarController extends AbstractController
{
    #[Route('/monavatar', name: 'app_mon_avatar')]
    public function index(EntityManagerInterface $em): Response
    {
        //Récupérer l'utilisateur connecté et son argent
        $utilisateurConnecte = $this->getUser();
        $utilisateur = $em->getRepository(Utilisateur::class)->find($utilisateurConnecte);
        $argentPossede = $utilisateur->getArgentPossede();
        if (!$utilisateur) {
            return $this->redirectToRoute('app_login');
        }

        //Récupérer les objets possédés par l'utilisateur
        $accessoiresPossedes = $utilisateur->getPossession();

        //Récupérer la tenue de l'utilisateur
        $tenuePortee = $utilisateur->getTenuePortee();

        $vars = [
            'utilisateur' => $utilisateur,
            'argentPossede' => $argentPossede,
            'accessoiresPossedes' => $accessoiresPossedes,
            'tenuePortee' => $tenuePortee,
        ];
        return $this->render('mon_avatar/mon_avatar.html.twig', $vars);
    }
}
