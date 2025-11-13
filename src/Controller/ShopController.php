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

    #[Route('/magasin/{type?}', name: 'app_shop_type')]
    public function type(string $type, EntityManagerInterface $entityManager): Response
    {
        $accessoireRepository = $entityManager->getRepository(Accessoire::class);
        //Récupérer l'utilisateur connecté et son argent
        $utilisateurConnecte = $this->getUser();
        $utilisateur = $entityManager->getRepository(Utilisateur::class)->find($utilisateurConnecte);
        $argentPossede = $utilisateur->getArgentPossede();
        if (!$utilisateur) {
            return $this->redirectToRoute('app_login');
        }

        if ($type) {
            $accessoires = $accessoireRepository->findBy(['typeAccessoire' => $type]);
            if ($type == 'haut') {
                $typeToutCaractere = 'Hauts';
            }

            if ($type == 'bas') {
                $typeToutCaractere = 'Bas';
            }
            if ($type == 'tete') {
                $typeToutCaractere = 'Tête';
            }
            if ($type == 'animal') {
                $typeToutCaractere = 'Animaux';
            }
            if ($type == 'accessoireMainDroite') {
                $typeToutCaractere = 'Accessoires main droite';
            }
            if ($type == 'accessoireMainGauche') {
                $typeToutCaractere = 'Accessoires main gauche';
            }
            if ($type == 'fond') {
                $typeToutCaractere = 'Fonds';
            }
            if ($type == 'filtre') {
                $typeToutCaractere = 'Filtres';
            }

            if ($type == 'filtre' || $type == 'fond') {
                return $this->render('shop/type_grand.html.twig', [
                    'accessoires' => $accessoires,
                    'type' => $type,
                    'typeToutCaractere' => $typeToutCaractere,
                    'argentPossede' => $argentPossede,
                    'utilisateur' => $utilisateur,
                ]);
            } else {
                return $this->render('shop/type_petit.html.twig', [
                    'accessoires' => $accessoires,
                    'type' => $type,
                    'typeToutCaractere' => $typeToutCaractere,
                    'argentPossede' => $argentPossede,
                    'utilisateur' => $utilisateur,
                ]);
            }
        } else {
            return $this->render('shop/index.html.twig', [
                'type' => $type
            ]);
        }
    }

    #[Route('/magasin/{type?}/{id}', name: 'app_shop_achat')]
    public function achat(string $type, int $id, EntityManagerInterface $entityManager): Response

    {
        //Récupérer l'utilisateur connecté et son argent
        $utilisateurConnecte = $this->getUser();
        $utilisateur = $entityManager->getRepository(Utilisateur::class)->find($utilisateurConnecte);
        $argentPossede = $utilisateur->getArgentPossede();
        if (!$utilisateur) {
            return $this->redirectToRoute('app_login');
        }
        $accessoireRepository = $entityManager->getRepository(Accessoire::class);
        $accessoire = $accessoireRepository->find($id);

        return $this->render('shop/validation_achat.html.twig', [
            'type' => $type,
            'id' => $id,
            'argentPossede' => $argentPossede,
            'utilisateur' => $utilisateur,
            'accessoire' => $accessoire,
        ]);
    }
}
