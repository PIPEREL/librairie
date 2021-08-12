### FAIRE UN SERVICE DE PAIEMENT ###

https://dashboard.stripe.com/test/dashboard

sur ce site nous avons une clé publique et une clé secrète qui serviront à la communication avec l'api

## importer stripe ##

composer require stripe/stripe-php


## Créer les prérequis ##

-1 page controller qui réfèrera à 
-2 pages html.twig (une succès une echec) <!-- on crée donc 2 routes dans le controller -->

-ajouter aux deux routeurs  /{stripeSessionId} pour transmettre le numéro de la transaction (le nom entre {} est arbitraire), 
-ajouter (string $stripeSessionId) dans les paramètres des fonctions.

Créer un Service qui aura pour paramètres : 

 - deux variables : 
                    -une pour stocker le Stripeclient (ex : $stripe)  /!\ ne pas oublier d'importer la classe 
                    -une pour stocker le service qui gère le panier panier (ex : $carteservice) /!\ pas besoin d'importer le Service car on travaille dans le même NameSpace


initialiser le constructeur  : (ce dernier aura besoin de la classe contenant l'objet: ci dessus (CartService $cartService)) 

$this->stripe = new StripeClient('la clé secrète dans https://dashboard.stripe.com/test/dashboard')


## LES FONCTIONS  ##

# fonction create # 
<!-- crée une session de paiement -->

1- créer deux Url dynamiques permettant la redirection vers une page succès ou failure.

2- créer la table qui stockera le panier au format stripe :  1 item = amount (prix unitaire) , quantity (quantité) , currency (EUR) , name (nom de l'article)

## version js de stripe ##
ajouter à base.html : 
<script src="https://js.stripe.com/v3/"></script>