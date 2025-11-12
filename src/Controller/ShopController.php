<?php

namespace App\Controller;

use App\Entity\Accessoire;
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
        //Récupérer l'utilisateur connecté et son argent
        $utilisateurConnecte = $this->getUser();
        $utilisateur = $em->getRepository(Utilisateur::class)->find($utilisateurConnecte);
        $argentPossede = $utilisateur->getArgentPossede();
        if (!$utilisateur) {
            return $this->redirectToRoute('app_login');
        }


        //Récupérer les objets déjà possédés par l'utilisateur
        $accessoiresPossedes = $utilisateur->getPossession();

        //Récupérer tous les objets du shop par types
        $accessoiresHaut = $em->getRepository(Accessoire::class)->findBy(['typeAccessoire' => 'haut']);
        $accessoiresBas = $em->getRepository(Accessoire::class)->findBy(['typeAccessoire' => 'bas']);
        $accessoiresTete = $em->getRepository(Accessoire::class)->findBy(['typeAccessoire' => 'tete']);
        $accessoiresAnimal = $em->getRepository(Accessoire::class)->findBy(['typeAccessoire' => 'animal']);
        $accessoiresObjetMainDroite = $em->getRepository(Accessoire::class)->findBy(['typeAccessoire' => 'objet main droite']);
        $accessoiresObjetMainGauche = $em->getRepository(Accessoire::class)->findBy(['typeAccessoire' => 'objet main gauche']);
        $accessoiresFonds = $em->getRepository(Accessoire::class)->findBy(['typeAccessoire' => 'fonds']);
        $accessoiresFiltres = $em->getRepository(Accessoire::class)->findBy(['typeAccessoire' => 'filtres']);



        $vars = [
            'utilisateur' => $utilisateur,
            'argentPossede' => $argentPossede,
            'accessoiresPossedes' => $accessoiresPossedes,
            'accessoiresHaut' => $accessoiresHaut,
            'accessoiresBas' => $accessoiresBas,
            'accessoiresTete' => $accessoiresTete,
            'accessoiresAnimal' => $accessoiresAnimal,
            'accessoiresObjetMainDroite' => $accessoiresObjetMainDroite,
            'accessoiresObjetMainGauche' => $accessoiresObjetMainGauche,
            'accessoiresFonds' => $accessoiresFonds,
            'accessoiresFiltres' => $accessoiresFiltres,
        ];
        return $this->render('shop/index.html.twig', $vars);
    }
}
