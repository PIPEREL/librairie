<?php

namespace App\Service;

use App\Entity\Books;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService
{
    private $sessionInterface;

    public function __construct(SessionInterface $sessionInterface)
    {
        $this->sessionInterface = $sessionInterface;
    }

    public function get()
    {
        $cart = $this->sessionInterface->get('cart', ['total' => 0, 'elements' => []]);
        return $cart;
    }

    public function add(Books $book)
    {
        $cart = $this->get();


        $bookId = $book->getid();
        if (!isset($cart['elements'][$bookId])) {
            $cart['elements'][$bookId] = ['book' => $book, 'quantity' => 0];
        }

        $cart['elements'][$bookId]['quantity'] +=  1;
        $cart['total'] = $cart['total'] + $book->getPrice();

        $this->sessionInterface->set('cart', $cart);
    }

    public function minus(Books $book)
    {
        $cart = $this->get();

        $bookId = $book->getid();

        if (isset($cart['elements'][$bookId])) {

            $cart['total'] = $cart['total'] - $book->getPrice();
            $cart['elements'][$bookId]['quantity'] -=  1;
            if ($cart['elements'][$bookId]['quantity'] <= 0) {
                unset($cart['elements'][$bookId]);
            }
        }
        $this->sessionInterface->set('cart', $cart);
    }

    public function removebook(Books $book)
    {
        $cart = $this->get('cart', ['total'=>0, 'elements'=>[]]);
        
          $bookId = $book->getid();
        
         if (isset($cart['elements'][$bookId])){
         unset($cart['elements'][$bookId]);
        }
         $this->sessionInterface->set('cart', $cart);
    }

    public function clear(){
        $this->sessionInterface->remove('cart');
    }
}
