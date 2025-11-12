<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class ShopController extends AbstractController
{
    #[Route('/magasin', name: 'app_shop')]
    public function index(EntityManagerInterface $em): Response
    {
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
        return $this->render('shop/index.html.twig', $vars);
    }
}
