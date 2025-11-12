<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;

final class QuizzController extends AbstractController
{
    #[Route('/questionnaire', name: 'app_quizz')]
    public function index(EntityManagerInterface $em): Response
    {
        //Récupérer l'utilisateur connecté et son argent
        $utilisateur = $this->getUser();
        $utilisateurConnecte = $this->getUser();
        $utilisateur = $em->getRepository(Utilisateur::class)->find($utilisateurConnecte);
        $argentPossede = $utilisateur->getArgentPossede();
        if (!$utilisateur) {
            return $this->redirectToRoute('app_login');
        }


        
        $vars = [
            'utilisateur' => $utilisateur,
            'argentPossede' => $argentPossede,
        ];
        return $this->render('quizz/index.html.twig', $vars);
    }
}
