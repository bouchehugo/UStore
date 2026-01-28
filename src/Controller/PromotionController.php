<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PromotionController extends AbstractController
{
    #[Route('/promotion', name: 'promotion')]
    public function index(): Response
    {
        return $this->render('promotion/index.html.twig');
    }
}
