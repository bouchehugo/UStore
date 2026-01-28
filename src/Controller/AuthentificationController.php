<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AuthentificationController extends AbstractController
{
    #[Route('/connexion', name: 'connexion')]
    public function connexion(): Response
    {
        return $this->render('authentification/connexion.html.twig');
    }

    #[Route('/inscription', name: 'inscription')]
    public function inscription(): Response
    {
        return $this->render('authentification/inscription.html.twig');
    }
}
