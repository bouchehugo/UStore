<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProduitController extends AbstractController
{
    #[Route('/produit', name: 'produit')]
    public function index(ArticleRepository $articleRepository): Response
    {
        $products = array_map(
            fn (Article $article): array => $this->formatProduct($article),
            $articleRepository->findBy([], ['id' => 'ASC'])
        );

        return $this->render('produit/index.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/produit/{id}', name: 'produit_detail')]
    public function detail(int $id, Request $request, ArticleRepository $articleRepository): Response
    {
        $article = $articleRepository->find($id);
        if (!$article) {
            throw $this->createNotFoundException('Produit introuvable.');
        }

        $product = $this->formatProduct($article);

        if ($request->isMethod('POST')) {
            $quantity = max(1, (int) $request->request->get('quantity', 1));

            if ($quantity > $article->getStockActuel()) {
                $this->addFlash('error', 'Stock insuffisant pour cette quantite.');
            } else {
                $session = $request->getSession();
                $cart = $session->get('cart', []);
                $productId = (string) $product['id'];

                if (isset($cart[$productId])) {
                    $cart[$productId]['quantity'] += $quantity;
                } else {
                    $cart[$productId] = [
                        'id' => $product['id'],
                        'name' => $product['name'],
                        'price' => $product['price'],
                        'image' => $product['image'],
                        'quantity' => $quantity,
                    ];
                }

                $session->set('cart', $cart);
                $this->addFlash('success', 'Produit ajoute au panier.');

                return $this->redirectToRoute('panier');
            }
        }

        return $this->render('produit/detail.html.twig', [
            'product' => $product,
        ]);
    }

    private function formatProduct(Article $article): array
    {
        $reference = strtolower($article->getReference());
        $mediaMap = [
            'bs_shake' => ['image' => 'images/accueil/bs_shake.png', 'price' => 29.90],
            'bs_pb' => ['image' => 'images/accueil/bs_pb.png', 'price' => 12.50],
            'bs_tee' => ['image' => 'images/accueil/bs_tee.png', 'price' => 24.90],
            'tee_a' => ['image' => 'images/accueil/tee_A.png', 'price' => 26.90],
            'gilet_a' => ['image' => 'images/accueil/gilet_A.png', 'price' => 49.90],
            'shoes_a' => ['image' => 'images/accueil/shoes_A.png', 'price' => 89.90],
        ];
        $mapped = $mediaMap[$reference] ?? ['image' => 'images/logo_ustore_r.png', 'price' => 39.90];

        return [
            'id' => $article->getId(),
            'reference' => $article->getReference(),
            'name' => $article->getLibelle(),
            'category' => $article->getCategorie()->getNom(),
            'stock' => $article->getStockActuel(),
            'price' => $mapped['price'],
            'image' => $mapped['image'],
        ];
    }
}