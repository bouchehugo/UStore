<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ServiceClientController extends AbstractController
{
    #[Route('/service-client', name: 'service_client')]
    public function index(): Response
    {
        return $this->render('service_client/index.html.twig');
    }
}