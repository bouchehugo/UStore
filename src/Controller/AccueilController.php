<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AccueilController extends AbstractController
{
    #[Route('/', name: 'accueil')]
    public function index(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findBy([], ['id' => 'ASC']);
        $catalog = array_map(fn (Article $article): array => $this->formatProduct($article), $articles);

        $bestSellers = array_slice($catalog, 0, 3);
        $newCollection = array_slice($catalog, 3, 3);

        return $this->render('accueil/index.html.twig', [
            'best_sellers' => $bestSellers,
            'new_collection' => $newCollection,
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
            'name' => $article->getLibelle(),
            'price' => $mapped['price'],
            'category' => $article->getCategorie()->getNom(),
            'image' => $mapped['image'],
        ];
    }
}
