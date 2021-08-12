<?php

namespace App\Service;

use DateTime;
use App\Entity\Commande;
use App\Entity\CommandeDetail;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CommandeService
{
    private $sessionInterface;
    private $cartService;

    public function __construct(SessionInterface $sessionInterface, CartService $cartService)
    {
        $this->sessionInterface = $sessionInterface;
        $this->cartService = $cartService;
    }


    public function New(string $stripeSessionId){
        $time = new DateTime('NOW');
        $commande = new Commande;
        $commande->setCreatedAt($time);
        $commande->setReference($stripeSessionId);

        return $commande;

    }

    public function Add(Commande $commande){
    $panier = $this->cartService->get();

    foreach ($panier['elements'] as $element){
        $commandeDetail = new CommandeDetail;
        $commandeDetail->setBook($element['book']);
        $commandeDetail->setQuantity($element['quantity']);
        // $element['book']->addCommandeDetail($commandeDetail);
        $commande->addCommandeDetail($commandeDetail);
 
    }
    

    }

  

}