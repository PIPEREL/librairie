<?php

namespace App\Service;

use App\Entity\Books;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CommandeDetailService
{
    private $sessionInterface;

    public function __construct(SessionInterface $sessionInterface)
    {
        $this->sessionInterface = $sessionInterface;
    }


    public function get(string $stripeSessionId){
        

    }














}