<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AuthentificationController extends AbstractController
{
    #[Route('/connexion', name: 'connexion')]
    public function connexion(
        Request $request,
        UserRepository $userRepository
    ): Response {
        if ($request->isMethod('POST')) {
            $email = trim((string) $request->request->get('email'));
            $password = (string) $request->request->get('password');

            $user = $userRepository->findOneBy(['email' => $email]);

            if (!$user || $user->getPassword() !== $password) {
                $this->addFlash('error', 'Adresse e-mail ou mot de passe incorrect.');
            } else {
                $request->getSession()->set('user_id', $user->getId());
                $request->getSession()->set('user_name', trim($user->getFirstname() . ' ' . $user->getLastname()));
                $this->addFlash('success', 'Connexion réussie, bienvenue ' . $user->getFirstname() . ' !');

                return $this->redirectToRoute('accueil');
            }
        }

        return $this->render('authentification/connexion.html.twig');
    }

    #[Route('/inscription', name: 'inscription')]
    public function inscription(
        Request $request,
        EntityManagerInterface $entityManager,
        UserRepository $userRepository
    ): Response {
        if ($request->isMethod('POST')) {
            $firstname = trim((string) $request->request->get('firstname'));
            $lastname = trim((string) $request->request->get('lastname'));
            $email = trim((string) $request->request->get('email'));
            $tel = trim((string) $request->request->get('tel'));
            $password = (string) $request->request->get('password');
            $passwordConfirm = (string) $request->request->get('password_confirm');

            if ($password !== $passwordConfirm) {
                $this->addFlash('error', 'Les mots de passe ne correspondent pas.');
            } elseif ($userRepository->findOneBy(['email' => $email])) {
                $this->addFlash('error', 'Un compte existe déjà avec cette adresse e-mail.');
            } else {
                $user = new User();
                $user
                    ->setFirstname($firstname)
                    ->setLastname($lastname)
                    ->setTel($tel !== '' ? $tel : null)
                    ->setEmail($email)
                    ->setPassword($password)
                    ->setRole('user');

                $entityManager->persist($user);
                $entityManager->flush();

                $this->addFlash('success', 'Compte créé avec succès. Vous pouvez maintenant vous connecter.');

                return $this->redirectToRoute('connexion');
            }
        }

        return $this->render('authentification/inscription.html.twig');
    }

    #[Route('/mot-de-passe-oublie', name: 'mot_de_passe_oublie')]
    public function motDePasseOublie(): Response
    {
        return $this->render('authentification/mot_de_passe_oublie.html.twig');
    }
}
