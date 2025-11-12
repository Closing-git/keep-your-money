<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class QuizzController extends AbstractController
{
    #[Route('/questionnaire', name: 'app_quizz')]
    public function index(): Response
    {
        $utilisateur = $this->getUser();
        if (!$utilisateur) {
            return $this->redirectToRoute('app_login');
        }
        $vars = [
            'utilisateur' => $utilisateur,
        ];
        return $this->render('quizz/index.html.twig', $vars);
    }
}
