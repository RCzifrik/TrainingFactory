<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class GuestController extends AbstractController
{
    #[Route('/', name: 'guest_home')]
    public function home(): Response
    {
        return $this->render('guest/index.html.twig');
    }

    #[Route('/login', name: 'guest_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('guest/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    #[Route('/register', name: 'guest_register')]
    public function register(): Response
    {
        return $this->render('guest/register.html.twig');
    }

    #[Route('/contact', name: 'guest_contact')]
    public function contact(): Response
    {
        return $this->render('guest/contact.html.twig');
    }

    #[Route('/trainerOverzicht', name: 'guest_trainerOverzicht')]
    public function trainerOverzicht(): Response
    {
        return $this->render('guest/trainerOverzicht.html.twig');
    }

    #[Route('/trainerDetail', name: 'guest_trainerDetail')]
    public function trainerDetail(): Response
    {
        return $this->render('guest/trainerDetail.html.twig');
    }

    #[Route('/trainingOverzicht', name: 'guest_trainingOverzicht')]
    public function trainingOverzicht(): Response
    {
        return $this->render('guest/trainingOverzicht.html.twig');
    }

    #[Route('/trainingDetail', name: 'guest_trainingDetail')]
    public function trainingDetail(): Response
    {
        return $this->render('guest/trainingDetail.html.twig');
    }

    #[Route('/redirect', name: 'redirect')]
    public function redirectAction(Security $security): Response
    {
        if ($security->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('admin_home');
        }
        if ($security->isGranted('ROLE_INSTRUCTOR')) {
            return $this->redirectToRoute('instructor_home');
        }
        if ($security->isGranted('ROLE_MEMBER')) {
            return $this->redirectToRoute('member_home');
        }
        return $this->redirectToRoute('guest_home');
    }

    #[Route('/logout', name: 'logout')]
    public function logout():Response
    {
        return $this->redirectToRoute('guest_home');
    }
}
