<?php

namespace App\Service;

use DateTime;
use App\Entity\Commande;
use App\Entity\CommandeDetail;
use App\Entity\Books;
use Doctrine\ORM\EntityManagerInterface;

class CommandeService
{
    private $cartService;

    public function __construct(CartService $cartService, EntityManagerInterface $em)
    {
        $this->cartService = $cartService;
        $this->em = $em;
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
        // $commandeDetail->setBook($element['book']);
        $commandeDetail->setQuantity($element['quantity']);
        $book = $this->em->getRepository(Books::class)->find($element['book']->getId());
        $book->addCommandeDetail($commandeDetail);
        $this->em->persist($book);
      
        // $element['book']->addCommandeDetail($commandeDetail);
        $commande->addCommandeDetail($commandeDetail);
 
    }
    $this->em->persist($commande);;
    $this->em->flush();

    }

  

}