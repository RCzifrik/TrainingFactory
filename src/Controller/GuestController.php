<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
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
    public function register(ManagerRegistry $doctrine, Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $entitymanager = $doctrine->getManager();
        $user = new User();
        $user->setRoles(["ROLE_MEMBER"]);
        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $hashedPassword = $passwordHasher->hashPassword($user, $user->getPassword());
            $user->setPassword($hashedPassword);
            $entitymanager->persist($user);
            $entitymanager->flush();
            return $this->redirectToRoute('guest_login');
        }
        return $this->renderForm('guest/register.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/contact', name: 'guest_contact')]
    public function contact(): Response
    {
        return $this->render('guest/contact.html.twig');
    }

    #[Route('/trainerOverzicht', name: 'guest_trainerOverzicht')]
    public function trainerOverzicht(ManagerRegistry $doctrine): Response
    {

        $trainers = $doctrine->getRepository(User::class)->findBy(['isTrainer' => true]);

        return $this->render('guest/trainerOverzicht.html.twig', [
            'trainers' => $trainers
        ]);
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
        return $this->render('guest/lessonDetail.html.twig');
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
