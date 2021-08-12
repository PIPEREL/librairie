<?php

namespace App\Controller;

use App\Entity\Books;
use App\Service\CartService;
use App\Service\PaiementService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PanierController extends AbstractController
{


    #[Route('/panier', name: 'panier')]
    public function index(CartService $cartService): Response
    {
        $cart = $cartService->get();
        
        return $this->render('panier/index.html.twig', [
          'cart' => $cart
        ]);
    }

    #[Route('/panier/ajouter/{id}', name: 'panier_add')]
    public function add(Books $book, CartService $CartService):Response
    {
        $CartService->add($book);
        return $this->redirectToRoute('panier');
    }

    #[Route('/panier/enlever/{id}', name: 'panier_enlever')]
    public function minus(Books $book, CartService $CartService):Response
    {
        $CartService->minus($book);

        return $this->redirectToRoute('panier');
    }

    #[Route('/panier/effacer/{id}', name: 'panier_effacer')]
    public function remove(Books $book, CartService $CartService):Response
    {
        $CartService->removebook($book);
        return $this->redirectToRoute('panier');
    }

    #[Route('/panier/clear', name: 'panier_vider')]
    public function clear(CartService $CartService):Response
    {
        $CartService->clear();
        return $this->redirectToRoute('panier');
    }

    #[Route('/panier/valider', name: 'panier_valider')]
    public function validate(PaiementService $paymentService):Response
    {
        $stripeSessionId = $paymentService->create();
        return $this->render('panier/redirect.html.twig', ['stripeSessionId' => $stripeSessionId]);
    }

}
