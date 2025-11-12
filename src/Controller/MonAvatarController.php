<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MonAvatarController extends AbstractController
{
    #[Route('/monavatar', name: 'app_mon_avatar')]
    public function index(): Response
    {
        $utilisateur = $this->getUser();
        if (!$utilisateur) {
            return $this->redirectToRoute('app_login');
        }

        $vars = [
            'utilisateur' => $utilisateur,
        ];
        return $this->render('mon_avatar/mon_avatar.html.twig', $vars);
    }
}
