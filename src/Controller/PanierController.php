<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PanierController extends AbstractController
{
    #[Route('/panier', name: 'panier')]
    public function index(Request $request): Response
    {
        $cart = $request->getSession()->get('cart', []);
        $items = array_values($cart);
        $total = 0.0;
        $totalQuantity = 0;

        foreach ($items as $item) {
            $lineTotal = $item['price'] * $item['quantity'];
            $total += $lineTotal;
            $totalQuantity += $item['quantity'];
        }

        return $this->render('panier/index.html.twig', [
            'items' => $items,
            'total' => $total,
            'total_quantity' => $totalQuantity,
        ]);
    }
}
