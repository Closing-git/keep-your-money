<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class QuizzController extends AbstractController
{
    #[Route('/questionnaire', name: 'app_quizz')]
    public function index(EntityManagerInterface $em, Request $request): Response
    {
        //Récupérer l'utilisateur connecté et son argent
        $utilisateur = $this->getUser();
        $utilisateurConnecte = $this->getUser();
        $utilisateur = $em->getRepository(Utilisateur::class)->find($utilisateurConnecte);
        $argentPossede = $utilisateur->getArgentPossede();
        if (!$utilisateur) {
            return $this->redirectToRoute('app_login');
        }

        if ($request->isMethod('POST') && $request->request->get('action') === 'gains') {
            $jetonsGagnes = (int) $request->request->get('jetonsGagnes', 0);
            if ($jetonsGagnes > 0) {
                $utilisateur->setArgentPossede($utilisateur->getArgentPossede() + $jetonsGagnes);
                $em->persist($utilisateur);
                $em->flush();

                $this->addFlash('success', sprintf('Félicitations ! Vous avez gagné %d 🪙', $jetonsGagnes));
            }

            return $this->redirectToRoute('app_quizz');
    
        }


        $vars = [
            'utilisateur' => $utilisateur,
            'argentPossede' => $utilisateur->getArgentPossede(),
        ];
        return $this->render('quizz/index.html.twig', $vars);
    }
}
