<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PromotionController extends AbstractController
{
    #[Route('/promotion', name: 'promotion')]
    public function index(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findBy([], ['id' => 'DESC']);
        $promotions = array_slice(
            array_map(fn (Article $article): array => $this->formatPromotion($article), $articles),
            0,
            6
        );

        return $this->render('promotion/index.html.twig', [
            'promotions' => $promotions,
        ]);
    }

    private function formatPromotion(Article $article): array
    {
        $discount = 10 + (($article->getId() ?? 1) % 4) * 5;
        $newPrice = 19.90 + (($article->getId() ?? 1) * 4.5);
        $oldPrice = $newPrice / (1 - ($discount / 100));

        return [
            'id' => $article->getId(),
            'name' => $article->getLibelle(),
            'old_price' => $oldPrice,
            'new_price' => $newPrice,
            'discount' => $discount,
            'badge' => 'Promo ' . $article->getCategorie()->getNom(),
        ];
    }
}
