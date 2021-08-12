<?php

namespace App\Service;

use Stripe\StripeClient;


Class PaiementService
{
    private $cartService;
    private $stripe;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
        $this->stripe = new StripeClient('sk_test_51JNEGdJJm0ou3sj12TxTtaxlZNiAC3qduKITkDHxCtdvpol2cEt1UvBcHWgBfUMsJ7MSGfeb6EepX9uKpGQGUUYw00QHJ8sh0I');
    }

    //function create une session de paiement stripe

    public function create():string
    {
        $protocol ="http";
        if(isset($_SERVER['HTTPS'])){
            $protocol ="https";
        }
        $serverName = $_SERVER['SERVER_NAME'];

        $successUrl= $protocol.'://' .$serverName. '/synfony2/librairie/public/paiement/success/{CHECKOUT_SESSION_ID}';
        $cancelUrl= $protocol.'://' .$serverName. '/synfony2/librairie/public/paiement/failure/{CHECKOUT_SESSION_ID}';

        $panier = $this->cartService->get();
        $items = [];
        foreach ($panier['elements'] as $element ){
            $item = [
                'amount' => $element['book']->getPrice()*100,
                'quantity' => $element['quantity'],
                'currency'=> 'eur',
                'name' => $element['book']->getTitle(),
            ];
            // array_push($items, $item);
            $items[] = $item;
        }

        $session = $this->stripe->checkout->sessions->create(
            [
             'success_url' => $successUrl,
             'cancel_url' => $cancelUrl,
             'shipping_rates'=> ['shr_1JNMByJJm0ou3sj1wTduEuf1'],
              'shipping_address_collection' => ['allowed_countries' => ['US', 'CA', 'FR', 'RU'],],
             'payment_method_types' => ['card'],
             'mode' => 'payment',
             'line_items' => $items   
            ]
        );
        return $session->id;
    }

}
