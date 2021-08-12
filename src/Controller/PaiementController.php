<?php

namespace App\Controller;

use DateTime;
use App\Entity\Commande;
use App\Service\CartService;
use App\Service\CommandeService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PaiementController extends AbstractController
{

    #[Route('/paiement/success/{stripeSessionId}', name: 'paiement_success')]
    public function success(string $stripeSessionId, CommandeService $commandeService, CartService $cartService): Response
    {
        $manager = $this->getDoctrine()->getManager();
        $commande = $commandeService->New($stripeSessionId);
        $commandeService->add($commande);
        // $manager->persist($commande);
        // $manager->flush();
        $cartService->clear();

        return $this->render('paiement/success.html.twig', [
            'stripeSessionId' => $stripeSessionId,
        ]);
    }

    #[Route('/paiement/failure/{stripeSessionId}', name: 'paiement_failure')]
    public function failure(string $stripeSessionId): Response
    {
        return $this->render('paiement/failure.html.twig', [
            'stripeSessionId' => $stripeSessionId,
        ]);
    }
}
