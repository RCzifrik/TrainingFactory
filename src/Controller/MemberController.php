<?php

namespace App\Controller;

use App\Entity\Lesson;
use App\Entity\Registration;
use App\Entity\Training;
use App\Entity\User;
use App\Form\SignUpType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class MemberController extends AbstractController
{
    #[Route('/member', name: 'member_home')]
    public function index(): Response
    {
        return $this->render('member/index.html.twig');
    }

    #[Route('/member/trainers', name: 'member_trainerOverzicht')]
    public function trainerOverzicht(ManagerRegistry $doctrine): Response
    {
        $trainer = $doctrine->getRepository(User::class)->findBy(['isTrainer' => true]);

        return $this->render('member/trainerOverzicht.html.twig', [
            'trainers' => $trainer
        ]);
    }

    #[Route('/member/trainers_details', name: 'member_trainerDetail')]
    public function trainerDetail(): Response
    {
        return $this->render('member/trainerDetail.html.twig');
    }

    #[Route('/member/trainingen', name: 'member_allTrainings')]
    public function allTrainings(ManagerRegistry $doctrine): Response
    {

        $training = $doctrine->getRepository(Training::class)->findAll();

        return $this->render('member/trainingOverzicht.html.twig', [
            'trainings' => $training
        ]);
    }

    #[Route('/member/trainingen/{id}', name: 'member_trainingSorted')]
    public function trainingSorted(ManagerRegistry $doctrine, int $id): Response
    {

        $lessons = $doctrine->getRepository(Lesson::class)->findBy(['training' => $id]);
        $trainings = $doctrine->getRepository(Training::class)->findBy(['id' => $id]);

        return $this->render('member/lessonOverzicht.html.twig', [
            'lessons' => $lessons,
            'trainings' => $trainings
        ]);
    }

    #[Route('/member/training_details/{id}', name: 'member_trainingDetail')]
    public function trainingDetail(ManagerRegistry $doctrine, int $id, Request $request, UserInterface $user): Response
    {
        $trainings = $doctrine->getRepository(Lesson::class)->findBy(['id' => $id]);

        $userId = $doctrine->getRepository(User::class)->findBy(['id' => $this->getUser()->getId()]);

        $entityManager = $doctrine->getManager();
        $registration = new Registration();

        $message = "";

        $form = $this->createForm(SignUpType::class, $registration);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $registration->setMember($userId[0]);
            $registration->setLesson($trainings[0]);
            $registration->setPayment(9.99);

            $dupeCheck = $doctrine->getRepository(Registration::class)->findBy(array('member' => $userId, 'lesson' => $trainings));
            if ($dupeCheck = null) {
                $entityManager->persist($registration);
                $entityManager->flush();
                return $this->redirectToRoute('member_home');
            }
            else {
                $message = "Je bent al ingeschreven voor deze les";
            }
        }

        return $this->renderForm('member/lessonDetail.html.twig', [
            'trainings' => $trainings,
            'form' => $form,
            'userID' => $userId,
            'message' => $message
        ]);
    }

    #[Route('/member/contact', name: 'member_contact')]
    public function contact(): Response
    {
        return $this->render('member/contact.html.twig');
    }
}
