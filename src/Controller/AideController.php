<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AideController extends AbstractController
{
    #[Route('/aide', name: 'aide')]
    public function index(): Response
    {
        return $this->render('aide/index.html.twig');
    }
}