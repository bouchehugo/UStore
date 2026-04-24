<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CategorieController extends AbstractController
{
    #[Route('/categorie', name: 'categorie')]
    public function index(CategorieRepository $categorieRepository): Response
    {
        $categories = array_map(
            fn (Categorie $category): array => [
                'name' => $category->getNom(),
                'description' => 'Decouvrez nos meilleurs produits dans la categorie ' . strtolower($category->getNom()) . '.',
                'products_count' => $category->getArticles()->count(),
                'featured_products' => array_slice(
                    array_map(
                        static fn ($article): string => $article->getLibelle(),
                        $category->getArticles()->toArray()
                    ),
                    0,
                    3
                ),
            ],
            $categorieRepository->findBy([], ['nom' => 'ASC'])
        );

        return $this->render('categorie/index.html.twig', [
            'categories' => $categories,
        ]);
    }
}
