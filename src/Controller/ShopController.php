<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ShopController extends AbstractController
{
    #[Route('/magasin', name: 'app_shop')]
    public function index(): Response
    {
        $utilisateur = $this->getUser();
        if (!$utilisateur) {
            return $this->redirectToRoute('app_login');
        }
        $vars = [
            'utilisateur' => $utilisateur,
        ];
        return $this->render('shop/index.html.twig', $vars);
    }
}
